import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import Underline from '@tiptap/extension-underline';

// Make available globally for Alpine.js
window.Editor = Editor;
window.StarterKit = StarterKit;
window.Link = Link;
window.Underline = Underline;

// Initialize all TipTap editors on page load
document.addEventListener('DOMContentLoaded', () => {
    // TipTap editors are initialized via Alpine.js x-init
});

console.log('TipTap editor loaded');
