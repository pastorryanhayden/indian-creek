@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
            </a>
            <h1 class="text-3xl font-bold">Edit User</h1>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="card bg-base-100 shadow-sm">
            @csrf
            @method('PUT')
            <div class="card-body space-y-6">
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-semibold">Name</span><span class="label-text-alt text-error">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input input-bordered w-full @error('name') input-error @enderror" required>
                    @error('name')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-semibold">Email</span><span class="label-text-alt text-error">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input input-bordered w-full @error('email') input-error @enderror" required>
                    @error('email')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-semibold">New Password</span></label>
                    <input type="password" name="password" class="input input-bordered w-full @error('password') input-error @enderror">
                    <label class="label"><span class="label-text-alt">Leave empty to keep current password</span></label>
                    @error('password')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-semibold">Confirm Password</span></label>
                    <input type="password" name="password_confirmation" class="input input-bordered w-full">
                </div>
                <div class="flex gap-6">
                    <label class="label cursor-pointer gap-2">
                        <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $user->hasRole('admin')) ? 'checked' : '' }} class="checkbox checkbox-primary">
                        <span class="label-text">Admin User</span>
                    </label>
                </div>
                <div class="flex gap-4 pt-4 border-t">
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
