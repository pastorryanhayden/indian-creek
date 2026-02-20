@php
$currentImageUrl = isset($currentImage) && $currentImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($currentImage) : '';
@endphp
<div class="w-full" x-data="imageUpload()" x-init="init('{{ $currentImageUrl }}')">
    <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">{{ $label }}</label>
    
    <!-- Current Image Preview -->
    <template x-if="currentImageUrl && !imagePreview">
        <div class="mb-4">
            <p class="text-xs mb-2" style="color: var(--color-text-secondary);">Current Image</p>
            <div class="relative inline-block">
                <img :src="currentImageUrl" alt="Current image" 
                     class="max-w-xs h-auto rounded-lg shadow-sm" 
                     style="border: 1px solid var(--color-border);">
                @if(!isset($keepExisting))
                    <button type="button" @click="removeCurrentImage()" 
                            class="absolute -top-2 -right-2 w-7 h-7 rounded-full flex items-center justify-center shadow-md transition-all hover:scale-110" 
                            style="background-color: #C62828; color: white;">
                        <x-tabler-x class="w-4 h-4" />
                    </button>
                @endif
            </div>
        </div>
    </template>
    
    <!-- New Image Preview -->
    <template x-if="imagePreview">
        <div class="mb-4">
            <p class="text-xs mb-2" style="color: var(--color-text-secondary);">New Image Preview</p>
            <div class="relative inline-block">
                <img :src="imagePreview" alt="Preview" 
                     class="max-w-xs h-auto rounded-lg shadow-sm" 
                     style="border: 1px solid var(--color-border);">
                <button type="button" @click="clearPreview()" 
                        class="absolute -top-2 -right-2 w-7 h-7 rounded-full flex items-center justify-center shadow-md transition-all hover:scale-110" 
                        style="background-color: #C62828; color: white;">
                    <x-tabler-x class="w-4 h-4" />
                </button>
            </div>
        </div>
    </template>
    
    <!-- File Input -->
    <div class="relative">
        <input 
            type="file" 
            :name="name" 
            :id="name"
            accept="{{ $accept ?? 'image/jpeg,image/png,image/gif,image/webp' }}"
            @change="handleFileChange($event)"
            class="w-full px-4 py-2.5 rounded-lg admin-input text-sm"
            {{ isset($required) && $required && !isset($currentImage) ? 'required' : '' }}
        >
    </div>
    
    @if(isset($helper))
        <p class="text-xs mt-1.5" style="color: var(--color-text-secondary);">{{ $helper }}</p>
    @endif
    
    <!-- Hidden input to track if current image should be removed -->
    @if(!isset($keepExisting))
        <input type="hidden" name="remove_{{ $name }}" x-model="removeCurrent">
    @endif
</div>

<script>
function imageUpload() {
    return {
        name: '{{ $name }}',
        currentImageUrl: null,
        imagePreview: null,
        removeCurrent: false,
        
        init(currentImage) {
            if (currentImage) {
                this.currentImageUrl = currentImage;
            }
        },
        
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        
        clearPreview() {
            this.imagePreview = null;
            const input = document.getElementById(this.name);
            if (input) {
                input.value = '';
            }
        },
        
        removeCurrentImage() {
            this.currentImageUrl = null;
            this.removeCurrent = true;
        }
    };
}
</script>
