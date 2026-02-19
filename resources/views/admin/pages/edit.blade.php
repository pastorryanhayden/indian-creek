@extends('admin.layouts.app')

@section('title', 'Edit Page')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
            </a>
            <h1 class="text-3xl font-bold">Edit Page</h1>
        </div>

        <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data" class="card bg-base-100 shadow-sm">
            @csrf
            @method('PUT')
            <div class="card-body space-y-6">
                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Page Information</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-semibold">Title</span><span class="label-text-alt text-error">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}" class="input input-bordered w-full @error('title') input-error @enderror" required>
                                @error('title')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
                            </div>
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-semibold">Slug</span><span class="label-text-alt text-error">*</span></label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}" class="input input-bordered w-full @error('slug') input-error @enderror" required>
                                @error('slug')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
                            </div>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Subtitle</span></label>
                            <input type="text" name="subtitle" value="{{ old('subtitle', $page->subtitle) }}" class="input input-bordered w-full">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-semibold">Location</span><span class="label-text-alt text-error">*</span></label>
                                <select name="location" class="select select-bordered w-full" required>
                                    <option value="about" {{ old('location', $page->location) == 'about' ? 'selected' : '' }}>About</option>
                                    <option value="camps" {{ old('location', $page->location) == 'camps' ? 'selected' : '' }}>Camps</option>
                                    <option value="resources" {{ old('location', $page->location) == 'resources' ? 'selected' : '' }}>Resources</option>
                                </select>
                            </div>
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-semibold">Status</span><span class="label-text-alt text-error">*</span></label>
                                <select name="status" class="select select-bordered w-full" required>
                                    <option value="active" {{ old('status', $page->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $page->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex gap-6">
                            <label class="label cursor-pointer gap-2">
                                <input type="checkbox" name="featured" value="1" {{ old('featured', $page->featured) ? 'checked' : '' }} class="checkbox checkbox-primary">
                                <span class="label-text">Featured Page</span>
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Icon</span></label>
                            <input type="text" name="icon" value="{{ old('icon', $page->icon) }}" class="input input-bordered w-full">
                        </div>
                        @include('admin.components.image-upload', [
                            'name' => 'image',
                            'label' => 'Image',
                            'currentImage' => $page->image,
                            'helper' => 'Max 2MB. Leave empty to keep current image.'
                        ])
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Content</h3>
                    @include('admin.components.tiptap-editor', ['name' => 'content', 'value' => old('content', $page->content), 'label' => 'Content'])
                </div>
                <div class="flex gap-4 pt-4 border-t">
                    <button type="submit" class="btn btn-primary">Update Page</button>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('title').addEventListener('blur', function() {
            const slugField = document.getElementById('slug');
            if (slugField.value === '') slugField.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
        });
    </script>
@endsection
