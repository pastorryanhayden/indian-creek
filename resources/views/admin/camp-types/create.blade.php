@extends('admin.layouts.app')

@section('title', 'Create Camp Type')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.camp-types.index') }}" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
            </a>
            <h1 class="text-3xl font-bold">Create Camp Type</h1>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.camp-types.store') }}" method="POST" enctype="multipart/form-data" class="card bg-base-100 shadow-sm">
            @csrf
            
            <div class="card-body space-y-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Camp Type Details</h3>
                    
                    <div class="space-y-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Name</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" class="input input-bordered w-full @error('name') input-error @enderror" placeholder="e.g., Teen Camp" required>
                            @error('name')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                            <label class="label">
                                <span class="label-text-alt">This shows under the type on the main navigation</span>
                            </label>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Subtitle</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="input input-bordered w-full @error('subtitle') input-error @enderror" placeholder="Camp for Teens" required>
                            @error('subtitle')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label cursor-pointer justify-start gap-4">
                                <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="checkbox checkbox-primary">
                                <div>
                                    <span class="label-text font-semibold">Featured Type</span>
                                    <p class="text-sm text-base-content/70">Mark this type as featured to display prominently. Only one type should be featured.</p>
                                </div>
                            </label>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Image</span>
                            </label>
                            <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp" class="file-input file-input-bordered w-full @error('image') input-error @enderror">
                            @error('image')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                            <label class="label">
                                <span class="label-text-alt">Upload an image (max 2MB) to represent this camp type.</span>
                            </label>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Icon</span>
                            </label>
                            <input type="text" name="icon" value="{{ old('icon') }}" class="input input-bordered w-full @error('icon') input-error @enderror" placeholder="e.g., tent, flame, users">
                            @error('icon')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                            <label class="label">
                                <span class="label-text-alt">Enter a Tabler icon name (optional). Visit <a href="https://tabler.io/icons" target="_blank" class="link">tabler.io/icons</a></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Description</h3>
                    
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold">Description</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <textarea name="description" rows="4" class="textarea textarea-bordered w-full @error('description') textarea-error @enderror" placeholder="Describe the camp type..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-4 pt-4 border-t">
                    <button type="submit" class="btn btn-primary">Create Camp Type</button>
                    <a href="{{ route('admin.camp-types.index') }}" class="btn btn-ghost">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
