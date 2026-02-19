<div class="form-control w-full" x-data="tiptapEditor('{{ $name }}', {{ json_encode($value ?? '') }})" x-init="init()">
    <label class="label">
        <span class="label-text font-semibold">{{ $label }}</span>
        @if(isset($required) && $required)
            <span class="label-text-alt text-error">*</span>
        @endif
    </label>
    
    <!-- Toolbar -->
    <div class="join border border-base-300 rounded-t-lg p-2 bg-base-200">
        <button type="button" @click="toggleBold()" :class="{ 'btn-active': isBold }" class="btn btn-sm join-item" title="Bold">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 5h6a3.5 3.5 0 0 1 0 7h-6z" /><path d="M13 12h1a3.5 3.5 0 0 1 0 7h-7v-7" /></svg>
        </button>
        <button type="button" @click="toggleItalic()" :class="{ 'btn-active': isItalic }" class="btn btn-sm join-item" title="Italic">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 5l6 0" /><path d="M7 19l6 0" /><path d="M14 5l-4 14" /></svg>
        </button>
        <button type="button" @click="toggleUnderline()" :class="{ 'btn-active': isUnderline }" class="btn btn-sm join-item" title="Underline">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 5v5a5 5 0 0 0 10 0v-5" /><path d="M5 19h14" /></svg>
        </button>
        <div class="divider divider-horizontal mx-1"></div>
        <button type="button" @click="toggleHeading(2)" :class="{ 'btn-active': isH2 }" class="btn btn-sm join-item" title="Heading 2">
            H2
        </button>
        <button type="button" @click="toggleHeading(3)" :class="{ 'btn-active': isH3 }" class="btn btn-sm join-item" title="Heading 3">
            H3
        </button>
        <div class="divider divider-horizontal mx-1"></div>
        <button type="button" @click="toggleBulletList()" :class="{ 'btn-active': isBulletList }" class="btn btn-sm join-item" title="Bullet List">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l11 0" /><path d="M9 12l11 0" /><path d="M9 18l11 0" /><path d="M5 6l0 .01" /><path d="M5 12l0 .01" /><path d="M5 18l0 .01" /></svg>
        </button>
        <button type="button" @click="toggleOrderedList()" :class="{ 'btn-active': isOrderedList }" class="btn btn-sm join-item" title="Numbered List">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 6h9" /><path d="M11 12h9" /><path d="M12 18h8" /><path d="M4 16a2 2 0 1 1 4 0c0 .591 -.5 1 -1 1.5l-3 2.5h4" /><path d="M6 10v-6l-2 2" /></svg>
        </button>
        <div class="divider divider-horizontal mx-1"></div>
        <button type="button" @click="setLink()" :class="{ 'btn-active': isLink }" class="btn btn-sm join-item" title="Link">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
        </button>
        <button type="button" @click="unsetLink()" class="btn btn-sm join-item" title="Remove Link">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l3 -3l2 -2" /><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
        </button>
        <div class="divider divider-horizontal mx-1"></div>
        <button type="button" @click="undo()" class="btn btn-sm join-item" title="Undo">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
        </button>
        <button type="button" @click="redo()" class="btn btn-sm join-item" title="Redo">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 13l4 -4l-4 -4m4 4h-11a4 4 0 0 0 0 8h1" /></svg>
        </button>
    </div>
    
    <!-- Editor -->
    <div 
        x-ref="editor" 
        class="prose max-w-none min-h-[200px] p-4 border border-base-300 border-t-0 rounded-b-lg bg-base-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
    ></div>
    
    <!-- Hidden input for form submission -->
    <textarea 
        :name="name" 
        x-ref="textarea" 
        class="hidden"
    >{{ $value ?? '' }}</textarea>
    
    @if(isset($helper))
        <label class="label">
            <span class="label-text-alt">{{ $helper }}</span>
        </label>
    @endif
</div>

@push('scripts')
<script>
function tiptapEditor(name, initialContent) {
    return {
        name: name,
        editor: null,
        isBold: false,
        isItalic: false,
        isUnderline: false,
        isH2: false,
        isH3: false,
        isBulletList: false,
        isOrderedList: false,
        isLink: false,
        
        init() {
            // Initialize TipTap editor
            this.editor = new Editor({
                element: this.$refs.editor,
                extensions: [
                    StarterKit,
                    Underline,
                    Link.configure({
                        openOnClick: false,
                    }),
                ],
                content: initialContent,
                onUpdate: ({ editor }) => {
                    this.$refs.textarea.value = editor.getHTML();
                    this.updateToolbarState();
                },
                onSelectionUpdate: () => {
                    this.updateToolbarState();
                },
            });
            
            this.$refs.textarea.value = initialContent;
        },
        
        updateToolbarState() {
            this.isBold = this.editor.isActive('bold');
            this.isItalic = this.editor.isActive('italic');
            this.isUnderline = this.editor.isActive('underline');
            this.isH2 = this.editor.isActive('heading', { level: 2 });
            this.isH3 = this.editor.isActive('heading', { level: 3 });
            this.isBulletList = this.editor.isActive('bulletList');
            this.isOrderedList = this.editor.isActive('orderedList');
            this.isLink = this.editor.isActive('link');
        },
        
        toggleBold() {
            this.editor.chain().focus().toggleBold().run();
        },
        toggleItalic() {
            this.editor.chain().focus().toggleItalic().run();
        },
        toggleUnderline() {
            this.editor.chain().focus().toggleUnderline().run();
        },
        toggleHeading(level) {
            this.editor.chain().focus().toggleHeading({ level: level }).run();
        },
        toggleBulletList() {
            this.editor.chain().focus().toggleBulletList().run();
        },
        toggleOrderedList() {
            this.editor.chain().focus().toggleOrderedList().run();
        },
        setLink() {
            const previousUrl = this.editor.getAttributes('link').href;
            const url = window.prompt('URL', previousUrl);
            
            if (url === null) {
                return;
            }
            
            if (url === '') {
                this.editor.chain().focus().extendMarkRange('link').unsetLink().run();
                return;
            }
            
            this.editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
        },
        unsetLink() {
            this.editor.chain().focus().unsetLink().run();
        },
        undo() {
            this.editor.chain().focus().undo().run();
        },
        redo() {
            this.editor.chain().focus().redo().run();
        },
    };
}
</script>
@endpush
