<section
    style="background-image: url('/textures/topo.jpg');"
    class="grid grid-cols-12 py-16 md:py-20"
    x-data="{ entered: false, playing: false }"
    x-init="
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (reduceMotion) {
            entered = true;
            return;
        }
        requestAnimationFrame(() => entered = true);
    "
>
    @if($homePage?->show_video && $homePage?->main_video)
        @php
            $videoUrl = $homePage->main_video;
            $autoplayUrl = str_contains($videoUrl, '?')
                ? $videoUrl.'&autoplay=1&rel=0'
                : $videoUrl.'?autoplay=1&rel=0';
        @endphp
        <div
            class="video col-start-2 col-end-12 lg:col-start-7 lg:col-end-12 p-4 transition-all duration-1000 ease-out delay-200"
            :class="entered ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
        >
            <div class="relative aspect-video w-full overflow-hidden rounded-sm shadow-2xl bg-black ring-1 ring-black/10">
                <template x-if="playing">
                    <iframe
                        class="absolute inset-0 h-full w-full"
                        src="{{ $autoplayUrl }}"
                        title="Indian Creek Baptist Camp video"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen
                    ></iframe>
                </template>

                <button
                    type="button"
                    x-show="!playing"
                    x-cloak
                    @click="playing = true"
                    class="group absolute inset-0 flex w-full h-full items-center justify-center cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-red focus-visible:ring-offset-2"
                    aria-label="Play video"
                >
                    <img
                        src="/poster.png"
                        alt="Aerial view of Indian Creek Baptist Camp"
                        class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                    >
                    <div class="absolute inset-0 bg-black/25 transition-colors duration-500 group-hover:bg-black/35"></div>
                    <span class="relative z-10 flex h-16 w-16 md:h-20 md:w-20 items-center justify-center rounded-full bg-brand-red text-white shadow-lg transition-transform duration-300 group-hover:scale-110">
                        <svg class="ml-1 h-7 w-7 md:h-8 md:w-8" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M8 5.14v13.72L19 12 8 5.14z" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    @endif

    <div class="col-start-2 col-end-12 lg:col-end-7 lg:order-first mt-6 self-center">
        <h1
            class="text-8xl font-heading leading-20 transition-all duration-700 ease-out"
            :class="entered ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'"
        >
            {{ $homePage?->main_title ?? 'Made for More' }}
        </h1>
        <h3
            class="text-4xl tracking-tight transition-all duration-700 ease-out delay-100"
            :class="entered ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'"
        >
            {{ $homePage?->main_subtitle ?? 'Indian Creek 2027' }}
        </h3>
        @if($homePage?->hero_button_text && $homePage?->hero_button_url)
            <a
                href="{{ $homePage->hero_button_url }}"
                class="inline-flex bg-brand-red text-white py-3 uppercase font-heading text-xl px-8 rounded-full mt-3 hover:brightness-90 transition-all duration-700 ease-out delay-200"
                :class="entered ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'"
            >
                {{ $homePage->hero_button_text }}
            </a>
        @endif
    </div>
</section>
