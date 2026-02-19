@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold" style="color: var(--color-text-primary);">Dashboard</h1>
                <p class="mt-1" style="color: var(--color-text-secondary);">Welcome back, {{ auth()->user()->name }}</p>
            </div>
        </div>

        <!-- Stats Cards - 60% Neutral, subtle icons -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <div class="admin-card rounded-xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--color-text-secondary);">Camp Types</p>
                        <h3 class="text-3xl font-bold mt-1" style="color: var(--color-text-primary);">{{ $stats['camp_types'] }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--color-bg-secondary);">
                        <x-tabler-tag class="w-5 h-5" style="color: var(--color-text-secondary);" />
                    </div>
                </div>
            </div>

            <div class="admin-card rounded-xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--color-text-secondary);">Camp Weeks</p>
                        <h3 class="text-3xl font-bold mt-1" style="color: var(--color-text-primary);">{{ $stats['camp_weeks'] }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--color-bg-secondary);">
                        <x-tabler-calendar-event class="w-5 h-5" style="color: var(--color-text-secondary);" />
                    </div>
                </div>
            </div>

            <div class="admin-card rounded-xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--color-text-secondary);">Speakers</p>
                        <h3 class="text-3xl font-bold mt-1" style="color: var(--color-text-primary);">{{ $stats['speakers'] }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--color-bg-secondary);">
                        <x-tabler-microphone class="w-5 h-5" style="color: var(--color-text-secondary);" />
                    </div>
                </div>
            </div>

            <div class="admin-card rounded-xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--color-text-secondary);">Events</p>
                        <h3 class="text-3xl font-bold mt-1" style="color: var(--color-text-primary);">{{ $stats['events'] }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--color-bg-secondary);">
                        <x-tabler-calendar class="w-5 h-5" style="color: var(--color-text-secondary);" />
                    </div>
                </div>
            </div>

            <div class="admin-card rounded-xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--color-text-secondary);">Pages</p>
                        <h3 class="text-3xl font-bold mt-1" style="color: var(--color-text-primary);">{{ $stats['pages'] }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--color-bg-secondary);">
                        <x-tabler-file-text class="w-5 h-5" style="color: var(--color-text-secondary);" />
                    </div>
                </div>
            </div>

            <div class="admin-card rounded-xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--color-text-secondary);">Users</p>
                        <h3 class="text-3xl font-bold mt-1" style="color: var(--color-text-primary);">{{ $stats['users'] }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--color-bg-secondary);">
                        <x-tabler-users class="w-5 h-5" style="color: var(--color-text-secondary);" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions - Only 10% accent on primary button -->
        <div class="admin-card rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--color-text-primary);">Quick Actions</h3>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.camp-types.create') }}" class="btn btn-sm px-4 py-2 rounded-lg font-medium admin-btn-primary">
                    <x-tabler-plus class="w-4 h-4 mr-1" />
                    New Camp Type
                </a>
                <a href="{{ route('admin.camp-weeks.create') }}" class="btn btn-sm px-4 py-2 rounded-lg font-medium admin-btn-ghost border" style="border-color: var(--color-border);">
                    <x-tabler-plus class="w-4 h-4 mr-1" />
                    New Camp Week
                </a>
                <a href="{{ route('admin.speakers.create') }}" class="btn btn-sm px-4 py-2 rounded-lg font-medium admin-btn-ghost border" style="border-color: var(--color-border);">
                    <x-tabler-plus class="w-4 h-4 mr-1" />
                    New Speaker
                </a>
                <a href="{{ route('admin.events.create') }}" class="btn btn-sm px-4 py-2 rounded-lg font-medium admin-btn-ghost border" style="border-color: var(--color-border);">
                    <x-tabler-plus class="w-4 h-4 mr-1" />
                    New Event
                </a>
                <a href="{{ route('admin.pages.create') }}" class="btn btn-sm px-4 py-2 rounded-lg font-medium admin-btn-ghost border" style="border-color: var(--color-border);">
                    <x-tabler-plus class="w-4 h-4 mr-1" />
                    New Page
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Camp Weeks -->
            <div class="admin-card rounded-xl">
                <div class="p-6 border-b" style="border-color: var(--color-border);">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold" style="color: var(--color-text-primary);">Recent Camp Weeks</h3>
                        <a href="{{ route('admin.camp-weeks.index') }}" class="admin-link text-sm font-medium hover:underline">View All</a>
                    </div>
                </div>
                <div class="p-0">
                    <table class="w-full">
                        <thead>
                            <tr class="admin-table-header">
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Type</th>
                                <th class="px-6 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentCampWeeks as $week)
                                <tr style="border-top: 1px solid var(--color-border);">
                                    <td class="px-6 py-3">
                                        <a href="{{ route('admin.camp-weeks.edit', $week) }}" class="font-medium hover:underline admin-link">
                                            {{ $week->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3" style="color: var(--color-text-secondary);">{{ $week->type->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-3">
                                        @php
                                            $statusClass = match($week->status) {
                                                'active' => 'admin-badge-success',
                                                'full' => 'admin-badge-error',
                                                'almost full' => 'admin-badge-warning',
                                                default => 'admin-badge-ghost'
                                            };
                                        @endphp
                                        <span class="badge badge-sm {{ $statusClass }}">
                                            {{ ucfirst($week->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center" style="color: var(--color-text-secondary);">No camp weeks found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="admin-card rounded-xl">
                <div class="p-6 border-b" style="border-color: var(--color-border);">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold" style="color: var(--color-text-primary);">Upcoming Events</h3>
                        <a href="{{ route('admin.events.index') }}" class="admin-link text-sm font-medium hover:underline">View All</a>
                    </div>
                </div>
                <div class="p-0">
                    <table class="w-full">
                        <thead>
                            <tr class="admin-table-header">
                                <th class="px-6 py-3 text-left">Title</th>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcomingEvents as $event)
                                <tr style="border-top: 1px solid var(--color-border);">
                                    <td class="px-6 py-3">
                                        <a href="{{ route('admin.events.edit', $event) }}" class="font-medium hover:underline admin-link">
                                            {{ $event->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3" style="color: var(--color-text-secondary);">{{ $event->start_date?->format('M j, Y') }}</td>
                                    <td class="px-6 py-3">
                                        <span class="badge badge-sm {{ $event->is_open ? 'admin-badge-success' : 'admin-badge-error' }}">
                                            {{ $event->is_open ? 'Open' : 'Closed' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center" style="color: var(--color-text-secondary);">No upcoming events</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
