@extends('layouts.main')

@section('title', $event->title)

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
                            <a href="{{ route('events.index') }}" class="ml-4 text-sm font-medium text-brand-green hover:text-gray-700">Other Events</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="size-5 shrink-0 text-brand-green" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-brand-green" aria-current="page">{{ $event->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <h1 class="font-heading text-6xl mt-4 mx-auto">{{ $event->title }}</h1>
            <p class="mt-3 text-lg font-semibold text-brand-green">
                {{ $event->start_date?->format('F j, Y') }}
                @if($event->end_date && ! $event->start_date?->isSameDay($event->end_date))
                    &ndash; {{ $event->end_date->format('F j, Y') }}
                @endif
            </p>

            @if($event->image)
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($event->image) }}"
                    alt="{{ $event->title }}"
                    class="w-full mx-auto mt-6 object-cover"
                >
            @endif

            @if($event->description)
                <p class="mt-6 text-xl text-gray-800 leading-relaxed">
                    {{ $event->description }}
                </p>
            @endif

            @if($event->speakers->isNotEmpty())
                <div class="mt-10">
                    <h2 class="font-heading text-4xl mb-6">Speakers</h2>
                    <div class="flex flex-wrap gap-6 justify-start">
                        @foreach($event->speakers as $speaker)
                            <div class="flex flex-col items-center w-40 shrink-0">
                                <div class="relative w-full h-48 overflow-hidden" style="clip-path: polygon(20% 0%, 100% 0%, 80% 100%, 0% 100%)">
                                    <img
                                        src="{{ $speaker->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($speaker->image) : '/default-speaker.jpg' }}"
                                        alt="{{ $speaker->name }}"
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                                <h3 class="mt-3 text-2xl font-heading text-center">{{ $speaker->name }}</h3>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($event->content)
                <div class="prose p-6 bg-white w-full max-w-4xl mx-auto mt-6">
                    {!! $event->content !!}
                </div>
            @endif

            <div class="mt-10">
                <a href="{{ route('events.index') }}" class="text-brand-red font-semibold hover:underline">
                    &larr; All events
                </a>
            </div>
        </section>
    </div>
@endsection
