@extends('admin.layouts.app')

@section('title', 'Create Camp Week')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.camp-weeks.index') }}" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
            </a>
            <h1 class="text-3xl font-bold">Create Camp Week</h1>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.camp-weeks.store') }}" method="POST" class="card bg-base-100 shadow-sm">
            @csrf
            
            <div class="card-body space-y-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Basic Information</h3>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Name</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="input input-bordered w-full @error('name') input-error @enderror" required>
                                @error('name')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Slug</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="input input-bordered w-full @error('slug') input-error @enderror" required>
                                @error('slug')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Camp Type</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="type_id" class="select select-bordered w-full @error('type_id') select-error @enderror" required>
                                    <option value="">Select a type</option>
                                    @foreach($campTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Status</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="status" class="select select-bordered w-full @error('status') select-error @enderror" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="almost full" {{ old('status') == 'almost full' ? 'selected' : '' }}>Almost Full</option>
                                    <option value="full" {{ old('status') == 'full' ? 'selected' : '' }}>Full</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="hidden" {{ old('status') == 'hidden' ? 'selected' : '' }}>Hidden</option>
                                </select>
                                @error('status')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Schedule -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Schedule</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Start Date</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" class="input input-bordered w-full @error('start_date') input-error @enderror" required>
                            @error('start_date')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">End Date</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" class="input input-bordered w-full @error('end_date') input-error @enderror" required>
                            @error('end_date')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Details -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Additional Details</h3>
                    
                    <div class="space-y-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Notes</span>
                            </label>
                            <textarea name="notes" rows="3" class="textarea textarea-bordered w-full @error('notes') textarea-error @enderror">{{ old('notes') }}</textarea>
                            @error('notes')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Speakers</span>
                            </label>
                            <select name="speakers[]" multiple class="select select-bordered w-full h-32 @error('speakers') select-error @enderror">
                                @foreach($speakers as $speaker)
                                    <option value="{{ $speaker->id }}" {{ in_array($speaker->id, old('speakers', [])) ? 'selected' : '' }}>
                                        {{ $speaker->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('speakers')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                            <label class="label">
                                <span class="label-text-alt">Hold Ctrl/Cmd to select multiple speakers</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-4 pt-4 border-t">
                    <button type="submit" class="btn btn-primary">Create Camp Week</button>
                    <a href="{{ route('admin.camp-weeks.index') }}" class="btn btn-ghost">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('name').addEventListener('blur', function() {
            const slugField = document.getElementById('slug');
            if (slugField.value === '') {
                slugField.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            }
        });
    </script>
@endsection
