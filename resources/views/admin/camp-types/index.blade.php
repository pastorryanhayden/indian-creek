@extends('admin.layouts.app')

@section('title', 'Camp Types')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold" style="color: var(--color-text-primary);">Camp Types</h1>
                <p class="mt-1" style="color: var(--color-text-secondary);">Manage different camp categories and programs</p>
            </div>
            <a href="{{ route('admin.camp-types.create') }}" class="btn px-6 py-2 rounded-lg font-medium admin-btn-primary">
                <x-tabler-plus class="w-5 h-5 mr-2" />
                Add Camp Type
            </a>
        </div>

        <!-- Table Card -->
        <div class="admin-card rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="admin-table-header">
                            <th class="px-6 py-4 text-left font-semibold">Camp Type</th>
                            <th class="px-6 py-4 text-left font-semibold">Image</th>
                            <th class="px-6 py-4 text-left font-semibold">Icon</th>
                            <th class="px-6 py-4 text-left font-semibold">Featured</th>
                            <th class="px-6 py-4 text-left font-semibold w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($campTypes as $type)
                            <tr style="border-top: 1px solid var(--color-border);">
                                <td class="px-6 py-4">
                                    <div class="font-semibold" style="color: var(--color-text-primary);">{{ $type->name }}</div>
                                    <div class="text-sm mt-0.5" style="color: var(--color-text-secondary);">{{ $type->subtitle }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($type->image)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($type->image) }}" alt="{{ $type->name }}" class="w-12 h-12 object-cover rounded-lg" style="border: 1px solid var(--color-border);">
                                    @else
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: var(--color-bg-secondary); border: 1px solid var(--color-border);">
                                            <x-tabler-photo class="w-5 h-5" style="color: var(--color-text-secondary);" />
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($type->icon)
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--color-accent-light);">
                                            @php
                                                // Strip 'tabler-' prefix if it exists
                                                $iconName = str_replace('tabler-', '', $type->icon);
                                            @endphp
                                            @svg("tabler-{$iconName}", 'w-5 h-5', ['style' => 'color: var(--color-accent);'])
                                        </div>
                                    @else
                                        <span style="color: var(--color-text-secondary); opacity: 0.5;">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($type->featured)
                                        <span class="badge admin-badge-success">Featured</span>
                                    @else
                                        <span class="badge admin-badge-ghost">No</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.camp-types.edit', $type) }}" class="btn btn-sm btn-ghost btn-square rounded-lg" style="color: var(--color-text-secondary);" title="Edit">
                                            <x-tabler-pencil class="w-4 h-4" />
                                        </a>
                                        <form action="{{ route('admin.camp-types.destroy', $type) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this camp type?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-ghost btn-square rounded-lg text-error" title="Delete">
                                                <x-tabler-trash class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background-color: var(--color-bg-secondary);">
                                            <x-tabler-tag class="w-8 h-8" style="color: var(--color-text-secondary);" />
                                        </div>
                                        <p style="color: var(--color-text-secondary);">No camp types found</p>
                                        <a href="{{ route('admin.camp-types.create') }}" class="btn btn-sm px-4 py-2 rounded-lg font-medium admin-btn-primary mt-2">
                                            Create your first camp type
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($campTypes->hasPages())
                <div class="px-6 py-4 border-t" style="border-color: var(--color-border);">
                    {{ $campTypes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
