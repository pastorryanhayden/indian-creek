@extends('admin.layouts.app')

@section('title', 'Create Page')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
            </a>
            <h1 class="text-3xl font-bold">Create Page</h1>
        </div>

        <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data" class="card bg-base-100 shadow-sm">
            @csrf
            <div class="card-body space-y-6">
                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Page Information</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-semibold">Title</span><span class="label-text-alt text-error">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" class="input input-bordered w-full @error('title') input-error @enderror" required>
                                @error('title')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
                            </div>
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-semibold">Slug</span><span class="label-text-alt text-error">*</span></label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="input input-bordered w-full @error('slug') input-error @enderror" required>
                                @error('slug')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
                            </div>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Subtitle</span></label>
                            <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="input input-bordered w-full" placeholder="e.g., Learn more about our mission">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-semibold">Location</span><span class="label-text-alt text-error">*</span></label>
                                <select name="location" class="select select-bordered w-full" required>
                                    <option value="about" {{ old('location') == 'about' ? 'selected' : '' }}>About</option>
                                    <option value="camps" {{ old('location') == 'camps' ? 'selected' : '' }}>Camps</option>
                                    <option value="resources" {{ old('location') == 'resources' ? 'selected' : '' }}>Resources</option>
                                </select>
                            </div>
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-semibold">Status</span><span class="label-text-alt text-error">*</span></label>
                                <select name="status" class="select select-bordered w-full" required>
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex gap-6">
                            <label class="label cursor-pointer gap-2">
                                <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="checkbox checkbox-primary">
                                <span class="label-text">Featured Page</span>
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Icon</span></label>
                            <input type="text" name="icon" value="{{ old('icon') }}" class="input input-bordered w-full" placeholder="e.g., info, book, users">
                            <label class="label"><span class="label-text-alt">Tabler icon name (optional)</span></label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Image</span></label>
                            <input type="file" name="image" accept="image/*" class="file-input file-input-bordered w-full">
                            <label class="label"><span class="label-text-alt">Max 2MB (optional)</span></label>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Content</h3>
                    @include('admin.components.tiptap-editor', ['name' => 'content', 'value' => old('content'), 'label' => 'Content'])
                </div>
                <div class="flex gap-4 pt-4 border-t">
                    <button type="submit" class="btn btn-primary">Create Page</button>
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
