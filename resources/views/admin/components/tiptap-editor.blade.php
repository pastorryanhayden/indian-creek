<div class="form-control w-full" data-controller="tiptap" data-tiptap-name-value="{{ $name }}">
    <label class="label">
        <span class="label-text font-semibold">{{ $label }}</span>
        @if(isset($required) && $required)
            <span class="label-text-alt text-error">*</span>
        @endif
    </label>

    <!-- Toolbar -->
    <div class="join border border-base-300 rounded-t-lg p-2 bg-base-200">
        <button type="button" data-action="tiptap#toggleBold" data-button-id="bold-btn" class="btn btn-sm join-item" title="Bold">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 5h6a3.5 3.5 0 0 1 0 7h-6z" /><path d="M13 12h1a3.5 3.5 0 0 1 0 7h-7v-7" /></svg>
        </button>
        <button type="button" data-action="tiptap#toggleItalic" data-button-id="italic-btn" class="btn btn-sm join-item" title="Italic">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 5l6 0" /><path d="M7 19l6 0" /><path d="M14 5l-4 14" /></svg>
        </button>
        <button type="button" data-action="tiptap#toggleUnderline" data-button-id="underline-btn" class="btn btn-sm join-item" title="Underline">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 5v5a5 5 0 0 0 10 0v-5" /><path d="M5 19h14" /></svg>
        </button>
        <div class="divider divider-horizontal mx-1"></div>
        <button type="button" data-action="tiptap#toggleH2" data-button-id="h2-btn" class="btn btn-sm join-item" title="Heading 2">
            H2
        </button>
        <button type="button" data-action="tiptap#toggleH3" data-button-id="h3-btn" class="btn btn-sm join-item" title="Heading 3">
            H3
        </button>
        <div class="divider divider-horizontal mx-1"></div>
        <button type="button" data-action="tiptap#toggleBulletList" data-button-id="bullet-list-btn" class="btn btn-sm join-item" title="Bullet List">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l11 0" /><path d="M9 12l11 0" /><path d="M9 18l11 0" /><path d="M5 6l0 .01" /><path d="M5 12l0 .01" /><path d="M5 18l0 .01" /></svg>
        </button>
        <button type="button" data-action="tiptap#toggleOrderedList" data-button-id="ordered-list-btn" class="btn btn-sm join-item" title="Numbered List">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 6h9" /><path d="M11 12h9" /><path d="M12 18h8" /><path d="M4 16a2 2 0 1 1 4 0c0 .591 -.5 1 -1 1.5l-3 2.5h4" /><path d="M6 10v-6l-2 2" /></svg>
        </button>
        <div class="divider divider-horizontal mx-1"></div>
        <button type="button" data-action="tiptap#setLink" data-button-id="link-btn" class="btn btn-sm join-item" title="Link">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
        </button>
        <button type="button" data-action="tiptap#unsetLink" class="btn btn-sm join-item" title="Remove Link">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l3 -3l2 -2" /><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
        </button>
        <div class="divider divider-horizontal mx-1"></div>
        <button type="button" data-action="tiptap#uploadImage" data-tiptap-target="uploadButton" class="btn btn-sm join-item" title="Upload Image">
            <span data-tiptap-target="uploadIcon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8h.01" /><path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z" /><path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" /><path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" /></svg>
            </span>
            <span data-tiptap-target="uploadSpinner" class="hidden">
                <span class="loading loading-spinner loading-sm"></span>
            </span>
        </button>
        <button type="button" data-action="tiptap#uploadFile" data-tiptap-target="fileUploadButton" class="btn btn-sm join-item" title="Upload File">
            <span data-tiptap-target="fileUploadIcon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 7l-6.5 6.5a1.5 1.5 0 0 0 3 3l6.5 -6.5a3 3 0 0 0 -6 -6l-6.5 6.5a4.5 4.5 0 0 0 9 9l6.5 -6.5" /></svg>
            </span>
            <span data-tiptap-target="fileUploadSpinner" class="hidden">
                <span class="loading loading-spinner loading-sm"></span>
            </span>
        </button>
        <div class="divider divider-horizontal mx-1"></div>
        <button type="button" data-action="tiptap#undo" class="btn btn-sm join-item" title="Undo">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
        </button>
        <button type="button" data-action="tiptap#redo" class="btn btn-sm join-item" title="Redo">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 13l4 -4l-4 -4m4 4h-11a4 4 0 0 0 0 8h1" /></svg>
        </button>
    </div>

    <!-- Editor -->
    <div
        data-tiptap-target="editor"
        class="prose max-w-none min-h-[200px] p-4 border border-base-300 border-t-0 rounded-b-lg bg-base-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
    ></div>

    <!-- Hidden file input for image upload -->
    <input type="file" data-tiptap-target="imageInput" data-action="change->tiptap#handleImageUpload" accept="image/*" class="hidden">
    <input type="file" data-tiptap-target="fileInput" data-action="change->tiptap#handleFileUpload" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.zip" class="hidden">

    <!-- Hidden input for form submission -->
    <textarea
        name="{{ $name }}"
        data-tiptap-target="textarea"
        class="hidden"
    >{{ $value ?? '' }}</textarea>

    @if(isset($helper))
        <label class="label">
            <span class="label-text-alt">{{ $helper }}</span>
        </label>
    @endif
</div>
