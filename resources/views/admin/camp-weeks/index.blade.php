@extends('admin.layouts.app')

@section('title', 'Camp Weeks')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold">Camp Weeks</h1>
            <a href="{{ route('admin.camp-weeks.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Add Camp Week
            </a>
        </div>

        <!-- Table -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Dates</th>
                                <th>Speakers</th>
                                <th class="w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($campWeeks as $week)
                                <tr>
                                    <td>
                                        <div class="font-medium">{{ $week->name }}</div>
                                        <div class="text-sm text-base-content/70">{{ $week->slug }}</div>
                                    </td>
                                    <td>{{ $week->type->name ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'active' => 'badge-success',
                                                'almost full' => 'badge-warning',
                                                'full' => 'badge-error',
                                                'inactive' => 'badge-ghost',
                                                'hidden' => 'badge-neutral',
                                            ];
                                        @endphp
                                        <span class="badge badge-sm {{ $statusColors[$week->status] ?? 'badge-ghost' }}">
                                            {{ ucfirst($week->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-sm">
                                            {{ $week->start_date?->format('M j') }} - {{ $week->end_date?->format('M j, Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($week->speakers->count() > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($week->speakers->take(2) as $speaker)
                                                    <span class="badge badge-sm badge-outline">{{ $speaker->name }}</span>
                                                @endforeach
                                                @if($week->speakers->count() > 2)
                                                    <span class="badge badge-sm">+{{ $week->speakers->count() - 2 }}</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-base-content/30 text-sm">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.camp-weeks.edit', $week) }}" class="btn btn-ghost btn-sm btn-square" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                            </a>
                                            <form action="{{ route('admin.camp-weeks.destroy', $week) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this camp week?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-ghost btn-sm btn-square text-error" title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-base-content/50">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="opacity-50"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3l0 4" /><path d="M8 3l0 4" /><path d="M4 11l16 0" /><path d="M8 15h2v2h-2z" /></svg>
                                            <p>No camp weeks found</p>
                                            <a href="{{ route('admin.camp-weeks.create') }}" class="btn btn-primary btn-sm mt-2">Create your first camp week</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($campWeeks->hasPages())
                    <div class="mt-4">
                        {{ $campWeeks->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
