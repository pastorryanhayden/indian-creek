<section style="background-image: url('/textures/topo.jpg');" class="top flex items-center justify-center py-20 z-1 relative">
    @if($campPage?->hero_video)
    <video
        class="absolute inset-0 w-full h-full object-cover z-[-2]"
        autoplay
        muted
        loop
        playsinline
        poster="{{ $campPage?->hero_poster ? (str_starts_with($campPage->hero_poster, '/') ? $campPage->hero_poster : '/storage/' . $campPage->hero_poster) : '/background.jpg' }}"
    >
        <source src="{{ str_starts_with($campPage->hero_video, '/') ? $campPage->hero_video : '/storage/' . $campPage->hero_video }}" type="video/mp4" />
        Your browser does not support the video tag.
    </video>
    @endif
    <div class="absolute inset-0 bg-black opacity-50 z-[-1]">

    </div>
    <div class="font-heading tex-base">
        <p class="text-4xl w-full border-b-6 border-base leading-tight text-base">{{ $campPage?->hero_season ?? 'Summer 2026' }}</p>
        <h2 class="text-8xl leading-22 mt-2 text-base">{{ $campPage?->hero_title ?? 'Summer' }}</h2>
        <div class="flex border-b-6 border-base "><h2 class="text-8xl mr-4 leading-22 text-base">Camp</h2> <p class="text-5xl mr-4 leading-10 text-base">{{ $campPage?->hero_subtitle ?? 'At ICBC' }}</p></div>
        <p class="text-2xl text-center font-sans w-40 mx-auto mt-4 text-base">{{ $campPage?->hero_helper_text ?? 'Start your adventure in 5 easy steps.' }}</p>

        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="text-base size-10 block mt-2 mx-auto"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5l-.117 .007a1 1 0 0 0 -.883 .993v4.999l-2.586 .001a2 2 0 0 0 -1.414 3.414l6.586 6.586a2 2 0 0 0 2.828 0l6.586 -6.586a2 2 0 0 0 .434 -2.18l-.068 -.145a2 2 0 0 0 -1.78 -1.089l-2.586 -.001v-4.999a1 1 0 0 0 -1 -1h-6z" /><path d="M15 2a1 1 0 0 1 .117 1.993l-.117 .007h-6a1 1 0 0 1 -.117 -1.993l.117 -.007h6z" /></svg>

    </div>
</section>
