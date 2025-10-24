<section style="background-image: url('/textures/topo.jpg');" class="grid grid-cols-12 py-20">

    @if($homePage?->show_video && $homePage?->main_video)
    <div class="video col-start-2 col-end-12 lg:col-start-7 lg:col-end-12 p-4">
        <iframe class="w-full aspect-video" src="{{ $homePage->main_video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
    @endif

    <div class="col-start-2 col-end-12 lg:col-end-7 lg:order-first mt-6">
        <h1 class="text-8xl font-heading leading-20 ">{{ $homePage?->main_title ?? 'Made for More' }}</h1>
        <h3 class="text-4xl tracking-tight">{{ $homePage?->main_subtitle ?? 'Indian Creek 2026' }}</h3>
        @if($homePage?->hero_button_text && $homePage?->hero_button_url)
        <a href="{{ $homePage->hero_button_url }}" class="inline-flex bg-accent text-white py-3 uppercase font-heading text-xl px-8 rounded-full mt-3">{{ $homePage->hero_button_text }}</a>
        @endif
    </div>
</section>
