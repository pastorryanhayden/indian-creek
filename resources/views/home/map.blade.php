@if($homePage?->show_directions_section)
<div
    class="w-full p-12 bg-black grid md:grid-cols-2 gap-6 md:gap-12"
    x-data="{ mapInView: false }"
    x-init="
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (reduceMotion) {
            mapInView = true;
            return;
        }
        const observer = new IntersectionObserver(([entry]) => {
            if (entry.isIntersecting) {
                mapInView = true;
                observer.disconnect();
            }
        }, { threshold: 0.35, rootMargin: '0px 0px -10% 0px' });
        observer.observe($el);
    "
>
    @if($homePage?->map_image && $homePage?->map_link)
        <a href="{{ $homePage->map_link }}" target="_blank" class="block overflow-hidden">
            <img
                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($homePage->map_image) }}"
                alt="Map"
                class="w-full h-full object-cover origin-center transition-transform duration-[2000ms] ease-out will-change-transform"
                :class="mapInView ? 'scale-[1.18]' : 'scale-100'"
            >
        </a>
    @endif
    <div class="text-base">
        <h3 class="font-heading text-6xl">{{ $homePage?->map_title ?? 'Spend your week at camp' }} <span class="text-brand-red">{{ $homePage?->map_highlight ?? '(not in the bus)' }}</span></h3>
        <p class="text-2xl">{{ $homePage?->map_description ?? 'Ideally located in Southern Indiana, ICBC is easy to get to from all parts of the South, and Midwest.' }}
        </p>
        @if($homePage?->map_distances && count($homePage->map_distances) > 0)
            <ul class="list-disc text-2xl ml-6 mt-4">
                @foreach($homePage->map_distances as $distance)
                    <li>{{ $distance['city'] }} - {{ $distance['distance'] }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endif
