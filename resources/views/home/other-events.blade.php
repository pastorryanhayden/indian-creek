@if(isset($homeEvents) && $homeEvents->isNotEmpty())
@php
    $singleEvent = $homeEvents->count() === 1;
@endphp
<section data-home-events class="w-full py-10 md:py-14 px-4 md:px-12" style="background-image: url('/textures/topo.jpg');">
    <div class="{{ $singleEvent ? 'max-w-6xl mx-auto' : 'grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 max-w-7xl mx-auto' }}">
        @foreach($homeEvents as $event)
            <a
                href="{{ route('events.show', $event->slug) }}"
                class="group relative block overflow-hidden shadow-xl {{ $singleEvent ? 'w-full min-h-[22rem] md:min-h-[32rem]' : 'min-h-[20rem] md:min-h-[28rem]' }}"
            >
                @if($event->image)
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($event->image) }}"
                        alt="{{ $event->title }}"
                        class="absolute inset-0 h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                    >
                @else
                    <div class="absolute inset-0 bg-brand-green"></div>
                @endif

                {{-- Soft bottom gradient only — keeps the photo visible --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>

                <div class="absolute inset-x-0 bottom-0 z-10 p-6 {{ $singleEvent ? 'md:p-10' : 'md:p-8' }} text-white">
                    <p class="text-sm md:text-base font-semibold uppercase tracking-wide text-white/90">
                        {{ $event->start_date?->format('F j, Y') }}
                        @if($event->end_date && ! $event->start_date?->isSameDay($event->end_date))
                            &ndash; {{ $event->end_date->format('F j, Y') }}
                        @endif
                    </p>
                    <h4 class="font-heading mt-1 leading-none {{ $singleEvent ? 'text-5xl md:text-7xl' : 'text-4xl md:text-5xl' }}">
                        {{ $event->title }}
                    </h4>
                    @if($event->description)
                        <p class="mt-3 max-w-2xl text-white/90 line-clamp-2 {{ $singleEvent ? 'text-base md:text-lg' : 'text-sm md:text-base' }}">
                            {{ $event->description }}
                        </p>
                    @endif
                    <span class="mt-4 inline-block text-sm md:text-base font-semibold uppercase tracking-wide text-white group-hover:underline">
                        Learn more &rarr;
                    </span>
                </div>
            </a>
        @endforeach
    </div>

    @if(! empty($showAllEventsLink))
        <div class="mt-8 md:mt-10 flex justify-center">
            <a
                href="{{ route('events.index') }}"
                class="inline-flex bg-brand-red text-white py-3 px-8 rounded-full text-xl md:text-2xl font-heading uppercase hover:brightness-75"
            >
                See all upcoming events
            </a>
        </div>
    @endif
</section>
@endif
