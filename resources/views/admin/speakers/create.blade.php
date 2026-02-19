@extends('admin.layouts.app')

@section('title', 'Create Speaker')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.speakers.index') }}" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
            </a>
            <h1 class="text-3xl font-bold">Create Speaker</h1>
        </div>

        <form action="{{ route('admin.speakers.store') }}" method="POST" enctype="multipart/form-data" class="card bg-base-100 shadow-sm">
            @csrf
            
            <div class="card-body space-y-6">
                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Personal Information</h3>
                    
                    <div class="space-y-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Name</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" class="input input-bordered w-full @error('name') input-error @enderror" required>
                            @error('name')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Image</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp" class="file-input file-input-bordered w-full @error('image') input-error @enderror" required>
                            @error('image')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Biography</h3>
                    
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold">Bio</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <textarea name="bio" rows="4" class="textarea textarea-bordered w-full @error('bio') textarea-error @enderror" required>{{ old('bio') }}</textarea>
                        @error('bio')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Assignments</h3>
                    
                    <div class="space-y-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Camp Weeks</span>
                            </label>
                            <select name="camp_weeks[]" multiple class="select select-bordered w-full h-32">
                                @foreach($campWeeks as $week)
                                    <option value="{{ $week->id }}" {{ in_array($week->id, old('camp_weeks', [])) ? 'selected' : '' }}>
                                        {{ $week->name }} ({{ $week->start_date?->format('M j') }} - {{ $week->end_date?->format('M j') }})
                                    </option>
                                @endforeach
                            </select>
                            <label class="label"><span class="label-text-alt">Hold Ctrl/Cmd to select multiple camp weeks</span></label>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Events</span>
                            </label>
                            <select name="events[]" multiple class="select select-bordered w-full h-32">
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" {{ in_array($event->id, old('events', [])) ? 'selected' : '' }}>
                                        {{ $event->title }} ({{ $event->start_date?->format('M j, Y') }})
                                    </option>
                                @endforeach
                            </select>
                            <label class="label"><span class="label-text-alt">Hold Ctrl/Cmd to select multiple events</span></label>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 pt-4 border-t">
                    <button type="submit" class="btn btn-primary">Create Speaker</button>
                    <a href="{{ route('admin.speakers.index') }}" class="btn btn-ghost">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
