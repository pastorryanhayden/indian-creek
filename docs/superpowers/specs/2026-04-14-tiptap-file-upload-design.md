# TipTap File Upload & Link — Design

## Purpose

Admin panel users need an easy way to upload a file (PDF, common office docs, CSV, ZIP) from the TipTap editor and link it to text, so they can attach downloadable resources inline while editing pages and events.

## UX

A new paperclip button sits in the editor toolbar next to the image upload button.

- If the user has text selected, clicking the button opens the OS file picker. After upload, the selected text becomes a link to the uploaded file.
- If nothing is selected, the original filename is inserted at the cursor and linked to the uploaded file.
- Links open in a new tab.
- While uploading, the button is disabled and a spinner replaces the icon (mirroring the existing image upload UX).
- On a 422 validation error, the server's error messages are shown via `alert()`. On any other error, a generic "File upload failed" alert is shown.

## Allowed File Types and Size

- Extensions: `pdf, doc, docx, xls, xlsx, ppt, pptx, txt, csv, zip`
- Max size: 10 MB (10240 KB)

## Backend

### Route

`POST /admin/upload/file` → `UploadController@file`, named `upload.file`. Lives alongside the existing `upload.image` route inside the admin middleware group.

### Controller

New `file` method on `App\Http\Controllers\Admin\UploadController`:

```php
public function file(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,zip|max:10240',
    ]);

    $uploaded = $request->file('file');
    $originalName = $uploaded->getClientOriginalName();

    $path = $uploaded->store('editor-files', ['disk' => 's3', 'visibility' => 'public']);

    return response()->json([
        'url' => Storage::disk('s3')->url($path),
        'name' => $originalName,
    ]);
}
```

Notes:
- Laravel's `store()` generates a hashed filename, avoiding collisions and URL-unsafe characters.
- The original filename is returned so the frontend can use it as link text when nothing is selected.
- Uses the `s3` disk with public visibility so the returned URL is directly linkable from the public site.

### Filesystem Config

This design assumes `config/filesystems.php` already has an `s3` disk configured (the image migration command implies it does). No changes are required if so. If the disk's default visibility is not public, the explicit `'visibility' => 'public'` on `store()` ensures the uploaded file is publicly readable.

## Frontend

### `resources/js/admin/tiptap.js`

Add to `static targets`: `fileInput`, `fileUploadButton`, `fileUploadIcon`, `fileUploadSpinner`.

New methods:

- `uploadFile()` — clicks the hidden `fileInput`.
- `handleFileUpload(event)` — posts the selected file to `/admin/upload/file`, then:
  - If the editor selection is non-empty: `editor.chain().focus().extendMarkRange('link').setLink({ href: url, target: '_blank', rel: 'noopener noreferrer' }).run()`.
  - Otherwise: `editor.chain().focus().insertContent(name).setTextSelection({ from, to: from + name.length }).setLink({ href: url, target: '_blank', rel: 'noopener noreferrer' }).run()` where `from` is the cursor position captured before insert.
  - Handles disable/spinner state the same way `handleImageUpload` does, and clears `event.target.value` in `finally`.
  - Error handling matches `handleImageUpload`: 422 shows the server's `errors.file` messages; any other error shows a generic alert.

The existing `Link` extension already supports `target` and `rel` attributes — no new extension required.

### `resources/views/admin/components/tiptap-editor.blade.php`

Add next to the image upload button:

- A paperclip button with `data-action="tiptap#uploadFile"`, `data-tiptap-target="fileUploadButton"`, and child icon/spinner spans targeted as `fileUploadIcon` / `fileUploadSpinner`.
- A hidden `<input type="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.zip" data-tiptap-target="fileInput" data-action="change->tiptap#handleFileUpload">`.

No changes needed to `updateToolbarState` — `link-btn` already reflects link-active state for either kind of link.

## Data Flow

1. User (optionally) selects text in the editor, clicks the paperclip button.
2. Hidden file input opens; user picks a file.
3. `handleFileUpload` posts `multipart/form-data` to `/admin/upload/file` with the CSRF-protected axios instance.
4. Server validates, stores to S3 under `editor-files/`, returns `{ url, name }`.
5. Client applies a link to the selection, or inserts the filename as linked text.
6. TipTap fires `onUpdate`, which writes the new HTML into the hidden textarea — saved with the form as normal.

## Security

- Route is inside the admin middleware group, matching the image endpoint.
- MIME/extension validation via Laravel's `mimes:` rule (checks the file's detected MIME against the extension list).
- Hashed filenames prevent path traversal and collisions.
- No database records are created; uploaded files are orphaned if the editor content is discarded. Acceptable for v1 — matches the image endpoint's behavior.

## Testing

Manual verification (there is no existing automated test suite for the editor):

- Upload a PDF with selected text → selected text becomes a link opening the PDF in a new tab.
- Upload a DOCX with nothing selected → filename appears as a link at the cursor.
- Upload a `.exe` → 422 error, user sees the validation message.
- Upload an 11 MB PDF → 422 error, user sees the size message.
- Submit the form after uploading → saved HTML contains the link with `target="_blank"`.

## Out of Scope

- Tracking uploaded files in the database / cleanup of orphans.
- Signed / time-limited URLs (public URLs are fine for this use case).
- Drag-and-drop upload into the editor.
- Migrating the existing image upload endpoint to S3 (called out separately; not part of this change).
