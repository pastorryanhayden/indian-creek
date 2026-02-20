import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import Underline from '@tiptap/extension-underline';
import Image from '@tiptap/extension-image';

window.tiptapEditor = function(name) {
    return {
        name: name,
        isBold: false,
        isItalic: false,
        isUnderline: false,
        isH2: false,
        isH3: false,
        isBulletList: false,
        isOrderedList: false,
        isLink: false,
        isUploading: false,

        // Get the raw editor, bypassing Alpine's reactive proxy which
        // breaks ProseMirror's internal state identity checks.
        getEditor() {
            return this.$refs.editor._tiptapEditor;
        },

        init() {
            const initialContent = this.$refs.textarea.value;

            this.$refs.editor._tiptapEditor = new Editor({
                element: this.$refs.editor,
                extensions: [
                    StarterKit.configure({
                        link: false,
                        underline: false,
                    }),
                    Underline,
                    Link.configure({
                        openOnClick: false,
                    }),
                    Image.configure({
                        inline: false,
                        allowBase64: false,
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
        },

        updateToolbarState() {
            this.isBold = this.getEditor().isActive('bold');
            this.isItalic = this.getEditor().isActive('italic');
            this.isUnderline = this.getEditor().isActive('underline');
            this.isH2 = this.getEditor().isActive('heading', { level: 2 });
            this.isH3 = this.getEditor().isActive('heading', { level: 3 });
            this.isBulletList = this.getEditor().isActive('bulletList');
            this.isOrderedList = this.getEditor().isActive('orderedList');
            this.isLink = this.getEditor().isActive('link');
        },

        toggleBold() {
            this.getEditor().chain().focus().toggleBold().run();
        },
        toggleItalic() {
            this.getEditor().chain().focus().toggleItalic().run();
        },
        toggleUnderline() {
            this.getEditor().chain().focus().toggleUnderline().run();
        },
        toggleHeading(level) {
            this.getEditor().chain().focus().toggleHeading({ level: level }).run();
        },
        toggleBulletList() {
            this.getEditor().chain().focus().toggleBulletList().run();
        },
        toggleOrderedList() {
            this.getEditor().chain().focus().toggleOrderedList().run();
        },
        setLink() {
            const previousUrl = this.getEditor().getAttributes('link').href;
            const url = window.prompt('URL', previousUrl);

            if (url === null) {
                return;
            }

            if (url === '') {
                this.getEditor().chain().focus().extendMarkRange('link').unsetLink().run();
                return;
            }

            this.getEditor().chain().focus().extendMarkRange('link').setLink({ href: url }).run();
        },
        unsetLink() {
            this.getEditor().chain().focus().unsetLink().run();
        },
        uploadImage() {
            this.$refs.imageInput.click();
        },
        handleImageUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.isUploading = true;

            const formData = new FormData();
            formData.append('image', file);

            window.axios.post('/admin/upload/image', formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            })
            .then(response => {
                this.getEditor().chain().focus().setImage({ src: response.data.url }).run();
            })
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    const message = errors.image ? errors.image.join('\n') : 'Validation failed.';
                    alert(message);
                } else {
                    alert('Image upload failed. Please try again.');
                }
            })
            .finally(() => {
                this.isUploading = false;
                event.target.value = '';
            });
        },
        undo() {
            this.getEditor().chain().focus().undo().run();
        },
        redo() {
            this.getEditor().chain().focus().redo().run();
        },
    };
};
