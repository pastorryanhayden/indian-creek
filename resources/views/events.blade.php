@extends('layouts.main')

@section('title', 'Other Events')

@section('content')
    <div class="w-full md:px-12 min-h-screen pt-6 md:pt-12 pb-48 bg-base z-10 bg-bottom bg-no-repeat bg-contain" style="background-image: url('/landscape2.jpg');">
        <section class="block w-full max-w-4xl mx-auto px-4 md:px-0">
            <nav class="flex" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="/" class="text-brand-green hover:text-gray-500">
                                <svg class="size-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z" clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">Home</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="size-5 shrink-0 text-brand-green" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-brand-green" aria-current="page">Other Events</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <h1 class="font-heading text-6xl mt-4 mx-auto">Other Events</h1>
            <p class="mt-4 text-lg text-gray-700 max-w-2xl">
                Special gatherings and seasonal events at Indian Creek Baptist Camp.
            </p>

            <div class="mt-10 space-y-8">
                @forelse($events as $event)
                    <a href="{{ route('events.show', $event->slug) }}" class="group block bg-white shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                        <div class="grid grid-cols-1 md:grid-cols-3">
                            @if($event->image)
                                <div class="md:col-span-1 min-h-48 md:min-h-full overflow-hidden">
                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($event->image) }}"
                                        alt="{{ $event->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    >
                                </div>
                            @endif
                            <div class="p-6 md:p-8 {{ $event->image ? 'md:col-span-2' : 'md:col-span-3' }}">
                                <p class="text-sm font-semibold uppercase tracking-wide text-brand-green">
                                    {{ $event->start_date?->format('F j, Y') }}
                                    @if($event->end_date && ! $event->start_date?->isSameDay($event->end_date))
                                        &ndash; {{ $event->end_date->format('F j, Y') }}
                                    @endif
                                </p>
                                <h2 class="font-heading text-4xl md:text-5xl mt-2 group-hover:text-brand-green transition-colors">
                                    {{ $event->title }}
                                </h2>
                                @if($event->description)
                                    <p class="mt-3 text-gray-700 leading-relaxed">
                                        {{ $event->description }}
                                    </p>
                                @endif
                                <span class="inline-block mt-4 text-brand-red font-semibold group-hover:underline">
                                    Learn more &rarr;
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="bg-white p-8 md:p-12 text-center shadow-md">
                        <h2 class="font-heading text-3xl text-gray-800">No upcoming events</h2>
                        <p class="mt-3 text-gray-600">Check back soon for special gatherings at Indian Creek.</p>
                        <a href="/" class="inline-block mt-6 bg-brand-red text-white py-3 px-6 rounded-full text-xl font-heading hover:brightness-75">
                            Back to Home
                        </a>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
