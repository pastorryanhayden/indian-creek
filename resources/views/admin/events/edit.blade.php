@extends('admin.layouts.app')

@section('title', 'Edit Event')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.events.index') }}" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
            </a>
            <h1 class="text-3xl font-bold">Edit Event</h1>
        </div>

        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="card bg-base-100 shadow-sm">
            @csrf
            @method('PUT')
            
            <div class="card-body space-y-6">
                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Basic Information</h3>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Title</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" class="input input-bordered w-full @error('title') input-error @enderror" required>
                                @error('title')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Slug</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug', $event->slug) }}" class="input input-bordered w-full @error('slug') input-error @enderror" required>
                                @error('slug')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
                            </div>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Description</span>
                            </label>
                            <textarea name="description" rows="3" class="textarea textarea-bordered w-full">{{ old('description', $event->description) }}</textarea>
                        </div>

                        @include('admin.components.image-upload', [
                            'name' => 'image',
                            'label' => 'Image',
                            'currentImage' => $event->image,
                            'helper' => 'Max 1MB. Leave empty to keep current image.'
                        ])
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Dates</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Start Date</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="date" name="start_date" value="{{ old('start_date', $event->start_date?->format('Y-m-d')) }}" class="input input-bordered w-full @error('start_date') input-error @enderror" required>
                            @error('start_date')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">End Date</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="date" name="end_date" value="{{ old('end_date', $event->end_date?->format('Y-m-d')) }}" class="input input-bordered w-full @error('end_date') input-error @enderror" required>
                            @error('end_date')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Status</h3>
                    
                    <div class="flex gap-6">
                        <label class="label cursor-pointer gap-2">
                            <input type="checkbox" name="is_open" value="1" {{ old('is_open', $event->is_open) ? 'checked' : '' }} class="checkbox checkbox-primary">
                            <span class="label-text">Open for Registration</span>
                        </label>
                        <label class="label cursor-pointer gap-2">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $event->is_featured) ? 'checked' : '' }} class="checkbox checkbox-warning">
                            <span class="label-text">Featured Event</span>
                        </label>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Content</h3>
                    
                    <div class="form-control w-full">
                        @include('admin.components.tiptap-editor', ['name' => 'content', 'value' => old('content', $event->content), 'label' => 'Content'])
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Speakers</h3>
                    
                    <div class="form-control w-full">
                        <select name="speakers[]" multiple class="select select-bordered w-full h-32">
                            @foreach($speakers as $speaker)
                                <option value="{{ $speaker->id }}" {{ in_array($speaker->id, old('speakers', $event->speakers->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $speaker->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="label"><span class="label-text-alt">Hold Ctrl/Cmd to select multiple speakers</span></label>
                    </div>
                </div>

                <div class="flex gap-4 pt-4 border-t">
                    <button type="submit" class="btn btn-primary">Update Event</button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-ghost">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('title').addEventListener('blur', function() {
            const slugField = document.getElementById('slug');
            if (slugField.value === '') {
                slugField.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            }
        });
    </script>
@endsection
