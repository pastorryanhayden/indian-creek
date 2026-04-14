import { Application, Controller } from '@hotwired/stimulus';
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import Underline from '@tiptap/extension-underline';
import Image from '@tiptap/extension-image';

const application = Application.start();

class TiptapController extends Controller {
    static targets = ['editor', 'textarea', 'imageInput', 'uploadButton', 'uploadIcon', 'uploadSpinner', 'fileInput', 'fileUploadButton', 'fileUploadIcon', 'fileUploadSpinner'];
    static values = { name: String };

    connect() {
        const initialContent = this.textareaTarget.value;

        this.editor = new Editor({
            element: this.editorTarget,
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
                this.textareaTarget.value = editor.getHTML();
                this.updateToolbarState();
            },
            onSelectionUpdate: () => {
                this.updateToolbarState();
            },
        });
    }

    disconnect() {
        this.editor.destroy();
    }

    updateToolbarState() {
        const checks = {
            'bold-btn': this.editor.isActive('bold'),
            'italic-btn': this.editor.isActive('italic'),
            'underline-btn': this.editor.isActive('underline'),
            'h2-btn': this.editor.isActive('heading', { level: 2 }),
            'h3-btn': this.editor.isActive('heading', { level: 3 }),
            'bullet-list-btn': this.editor.isActive('bulletList'),
            'ordered-list-btn': this.editor.isActive('orderedList'),
            'link-btn': this.editor.isActive('link'),
        };

        for (const [id, active] of Object.entries(checks)) {
            const btn = this.element.querySelector(`[data-button-id="${id}"]`);
            if (btn) {
                btn.classList.toggle('btn-active', active);
            }
        }
    }

    toggleBold() {
        this.editor.chain().focus().toggleBold().run();
    }

    toggleItalic() {
        this.editor.chain().focus().toggleItalic().run();
    }

    toggleUnderline() {
        this.editor.chain().focus().toggleUnderline().run();
    }

    toggleH2() {
        this.editor.chain().focus().toggleHeading({ level: 2 }).run();
    }

    toggleH3() {
        this.editor.chain().focus().toggleHeading({ level: 3 }).run();
    }

    toggleBulletList() {
        this.editor.chain().focus().toggleBulletList().run();
    }

    toggleOrderedList() {
        this.editor.chain().focus().toggleOrderedList().run();
    }

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
    }

    unsetLink() {
        this.editor.chain().focus().unsetLink().run();
    }

    uploadImage() {
        this.imageInputTarget.click();
    }

    uploadFile() {
        this.fileInputTarget.click();
    }

    handleImageUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        this.uploadButtonTarget.disabled = true;
        this.uploadIconTarget.classList.add('hidden');
        this.uploadSpinnerTarget.classList.remove('hidden');

        const formData = new FormData();
        formData.append('image', file);

        window.axios.post('/admin/upload/image', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then(response => {
            this.editor.chain().focus().setImage({ src: response.data.url }).run();
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
            this.uploadButtonTarget.disabled = false;
            this.uploadIconTarget.classList.remove('hidden');
            this.uploadSpinnerTarget.classList.add('hidden');
            event.target.value = '';
        });
    }

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

    undo() {
        this.editor.chain().focus().undo().run();
    }

    redo() {
        this.editor.chain().focus().redo().run();
    }
}

application.register('tiptap', TiptapController);
