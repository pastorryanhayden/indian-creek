# TipTap File Upload Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Let admin users upload a file (PDF, office docs, CSV, ZIP) from the TipTap editor and link it to selected text, or insert the filename as a link if no text is selected.

**Architecture:** Add a new `POST /admin/upload/file` endpoint on the existing `UploadController` that stores to S3 with public visibility and returns `{url, name}`. Add a paperclip toolbar button, hidden file input, and a `handleFileUpload` method to the existing Stimulus TipTap controller that uses the existing `Link` TipTap extension — no new extension required.

**Tech Stack:** Laravel 11, Stimulus.js, TipTap 2 (`@tiptap/core`, `@tiptap/extension-link`), S3 via `league/flysystem-aws-s3-v3`, axios, DaisyUI / Tailwind.

**Testing approach:** This project has no automated JS/feature test suite for the editor. Verification is manual via the admin UI (steps included). Controller changes get a PHPUnit feature test.

---

## File Structure

- **Modify** `app/Http/Controllers/Admin/UploadController.php` — add `file()` method
- **Modify** `routes/admin.php` — add `POST /upload/file` route
- **Modify** `resources/js/admin/tiptap.js` — add targets, `uploadFile()`, `handleFileUpload()`
- **Modify** `resources/views/admin/components/tiptap-editor.blade.php` — add paperclip button and hidden file input
- **Create** `tests/Feature/Admin/UploadControllerTest.php` — feature test for the new endpoint (only if no existing test file covers `UploadController`; the task checks first and creates or extends accordingly)

---

### Task 1: Add backend route and controller method

**Files:**
- Modify: `routes/admin.php` (around line 39, below the existing `upload.image` route)
- Modify: `app/Http/Controllers/Admin/UploadController.php`

- [ ] **Step 1: Confirm the `s3` disk is configured**

Run: `grep -n "'s3'" config/filesystems.php`
Expected: a disk block named `s3` exists with `driver => 's3'`. If missing, STOP and report to the user before continuing — the feature cannot ship without it.

- [ ] **Step 2: Add the route**

In `routes/admin.php`, directly below the existing line:
```php
Route::post('/upload/image', [UploadController::class, 'image'])->name('upload.image');
```
add:
```php
Route::post('/upload/file', [UploadController::class, 'file'])->name('upload.file');
```

- [ ] **Step 3: Add the `file()` method to `UploadController`**

Replace the full contents of `app/Http/Controllers/Admin/UploadController.php` with:

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function image(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $path = $request->file('image')->store('editor-images', 'public');

        return response()->json([
            'url' => Storage::disk('public')->url($path),
        ]);
    }

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
}
```

- [ ] **Step 4: Verify the route is registered**

Run: `php artisan route:list --name=upload.file`
Expected: a single row showing `POST admin/upload/file` → `Admin\UploadController@file`.

- [ ] **Step 5: Commit**

```bash
git add routes/admin.php app/Http/Controllers/Admin/UploadController.php
git commit -m "Add admin file upload endpoint for TipTap editor"
```

---

### Task 2: Feature test for the upload endpoint

**Files:**
- Test: `tests/Feature/Admin/UploadControllerTest.php` (create if missing; extend if present)

- [ ] **Step 1: Check if a test file already exists**

Run: `ls tests/Feature/Admin/UploadControllerTest.php 2>/dev/null || echo MISSING`
If `MISSING`, create a new file per Step 2. Otherwise, append only the three test methods from Step 2 into the existing class (keep existing tests untouched).

- [ ] **Step 2: Write the failing tests**

Create `tests/Feature/Admin/UploadControllerTest.php` with:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadControllerTest extends TestCase
{
    public function test_admin_can_upload_pdf_file(): void
    {
        Storage::fake('s3');
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/upload/file', [
            'file' => UploadedFile::fake()->create('handout.pdf', 100, 'application/pdf'),
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['url', 'name']);
        $this->assertSame('handout.pdf', $response->json('name'));
        $this->assertNotEmpty(Storage::disk('s3')->allFiles('editor-files'));
    }

    public function test_upload_rejects_disallowed_mime(): void
    {
        Storage::fake('s3');
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/upload/file', [
            'file' => UploadedFile::fake()->create('malware.exe', 100, 'application/octet-stream'),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('file');
    }

    public function test_upload_rejects_files_over_10mb(): void
    {
        Storage::fake('s3');
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/upload/file', [
            'file' => UploadedFile::fake()->create('huge.pdf', 10241, 'application/pdf'),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('file');
    }
}
```

- [ ] **Step 3: Run the tests to verify they pass**

Run: `php artisan test --filter=UploadControllerTest`
Expected: all three new tests pass.

If the test fails because `User::factory()` is not registered or the project doesn't use `Tests\TestCase`, look at an existing feature test (e.g. `grep -rl "class.*extends TestCase" tests/Feature | head -1`) and match its conventions — swap in the project's actual user factory / auth helper and re-run.

- [ ] **Step 4: Commit**

```bash
git add tests/Feature/Admin/UploadControllerTest.php
git commit -m "Test admin file upload endpoint validation and success path"
```

---

### Task 3: Add toolbar button and hidden file input to the Blade partial

**Files:**
- Modify: `resources/views/admin/components/tiptap-editor.blade.php`

- [ ] **Step 1: Add the paperclip button next to the image upload button**

In `resources/views/admin/components/tiptap-editor.blade.php`, find the block that starts with:
```html
<button type="button" data-action="tiptap#uploadImage" data-tiptap-target="uploadButton" ...
```
(currently around line 42) and the closing `</button>` that follows its `uploadSpinner` span (around line 49). Directly AFTER that closing `</button>`, insert:

```html
        <button type="button" data-action="tiptap#uploadFile" data-tiptap-target="fileUploadButton" class="btn btn-sm join-item" title="Upload File">
            <span data-tiptap-target="fileUploadIcon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 7l-6.5 6.5a1.5 1.5 0 0 0 3 3l6.5 -6.5a3 3 0 0 0 -6 -6l-6.5 6.5a4.5 4.5 0 0 0 9 9l6.5 -6.5" /></svg>
            </span>
            <span data-tiptap-target="fileUploadSpinner" class="hidden">
                <span class="loading loading-spinner loading-sm"></span>
            </span>
        </button>
```

- [ ] **Step 2: Add the hidden file input**

In the same file, find the existing hidden image input line (currently line 66):
```html
<input type="file" data-tiptap-target="imageInput" data-action="change->tiptap#handleImageUpload" accept="image/*" class="hidden">
```
Directly below it, insert:
```html
<input type="file" data-tiptap-target="fileInput" data-action="change->tiptap#handleFileUpload" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.zip" class="hidden">
```

- [ ] **Step 3: Commit**

```bash
git add resources/views/admin/components/tiptap-editor.blade.php
git commit -m "Add file upload button and input to TipTap editor toolbar"
```

---

### Task 4: Register new Stimulus targets and upload trigger method

**Files:**
- Modify: `resources/js/admin/tiptap.js`

- [ ] **Step 1: Extend the `static targets` array**

In `resources/js/admin/tiptap.js`, replace this line:
```js
static targets = ['editor', 'textarea', 'imageInput', 'uploadButton', 'uploadIcon', 'uploadSpinner'];
```
with:
```js
static targets = ['editor', 'textarea', 'imageInput', 'uploadButton', 'uploadIcon', 'uploadSpinner', 'fileInput', 'fileUploadButton', 'fileUploadIcon', 'fileUploadSpinner'];
```

- [ ] **Step 2: Add the `uploadFile()` method**

In the same file, directly AFTER the existing `uploadImage()` method (currently ends at line 118 with `}`), add:

```js
    uploadFile() {
        this.fileInputTarget.click();
    }
```

- [ ] **Step 3: Commit**

```bash
git add resources/js/admin/tiptap.js
git commit -m "Wire up file upload targets and trigger method in TipTap controller"
```

---

### Task 5: Implement `handleFileUpload`

**Files:**
- Modify: `resources/js/admin/tiptap.js`

- [ ] **Step 1: Add the `handleFileUpload` method**

In `resources/js/admin/tiptap.js`, directly AFTER the existing `handleImageUpload(event)` method's closing `}` (currently around line 152), and BEFORE the `undo()` method, insert:

```js
    handleFileUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        this.fileUploadButtonTarget.disabled = true;
        this.fileUploadIconTarget.classList.add('hidden');
        this.fileUploadSpinnerTarget.classList.remove('hidden');

        const { from, to, empty } = this.editor.state.selection;

        const formData = new FormData();
        formData.append('file', file);

        window.axios.post('/admin/upload/file', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then(response => {
            const { url, name } = response.data;
            const linkAttrs = { href: url, target: '_blank', rel: 'noopener noreferrer' };

            if (empty) {
                this.editor
                    .chain()
                    .focus()
                    .insertContentAt(from, name)
                    .setTextSelection({ from, to: from + name.length })
                    .setLink(linkAttrs)
                    .run();
            } else {
                this.editor
                    .chain()
                    .focus()
                    .setTextSelection({ from, to })
                    .extendMarkRange('link')
                    .setLink(linkAttrs)
                    .run();
            }
        })
        .catch(error => {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                const message = errors.file ? errors.file.join('\n') : 'Validation failed.';
                alert(message);
            } else {
                alert('File upload failed. Please try again.');
            }
        })
        .finally(() => {
            this.fileUploadButtonTarget.disabled = false;
            this.fileUploadIconTarget.classList.remove('hidden');
            this.fileUploadSpinnerTarget.classList.add('hidden');
            event.target.value = '';
        });
    }
```

Note: the selection `from`/`to`/`empty` are captured BEFORE the axios call because opening the file picker blurs the editor, but ProseMirror preserves the last known selection on `editor.state.selection`.

- [ ] **Step 2: Build the assets**

Run: `npm run build`
Expected: build succeeds, writing a new `public/build/assets/tiptap-*.js`. If the project uses dev watch instead, `npm run dev` is acceptable — just confirm the file rebuilds.

- [ ] **Step 3: Commit**

```bash
git add resources/js/admin/tiptap.js public/build
git commit -m "Handle file upload and link insertion in TipTap controller"
```

---

### Task 6: Manual verification in the admin UI

**Files:** none — this is an end-to-end sanity check.

- [ ] **Step 1: Start the app**

Run: `php artisan serve` (and `npm run dev` in another terminal if Vite isn't already running).

- [ ] **Step 2: Open a page with the editor**

Log in to the admin panel and open any page or event edit screen that uses `<x-tiptap-editor>`.

- [ ] **Step 3: Verify case A — upload with a selection**

Type some text, select a word, click the new paperclip button, pick a PDF. Expected: the selected word becomes an underlined link; clicking it (after saving) opens the PDF in a new tab.

- [ ] **Step 4: Verify case B — upload with no selection**

Place the cursor somewhere with no selection, click the paperclip, pick a DOCX. Expected: the original filename is inserted at the cursor as a link.

- [ ] **Step 5: Verify validation errors surface**

Try uploading a `.exe` — expect an alert with the server validation message. Try uploading an >10 MB PDF — expect an alert with the size message.

- [ ] **Step 6: Verify persistence**

Save the form, reload the page, confirm the link is still present in the editor and the linked file opens.

- [ ] **Step 7: If anything fails**

Report which step failed and the exact error (browser console + Laravel log). Do NOT commit — fix the underlying task first.

---

## Out of Scope (per spec)

- DB tracking / orphan cleanup of uploaded files
- Signed / expiring URLs
- Drag-and-drop upload into the editor
- Migrating the existing image upload endpoint to S3
