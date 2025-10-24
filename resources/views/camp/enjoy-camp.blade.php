<div class="bottom w-full px-8 md:px-12 pt-6 md:pt-12 pb-48 bg-base z-10 bg-bottom bg-no-repeat bg-contain " style="background-image: url('{{ $campPage?->step_5_background_image ? (str_starts_with($campPage->step_5_background_image, '/') ? $campPage->step_5_background_image : '/storage/' . $campPage->step_5_background_image) : '/landscape2.jpg' }}');">
    <h2 class="w-full text-center mt-8 mb-24 text-6xl font-heading text-secondary shrink-0">{{ $campPage?->step_5_title ?? 'Step 5: Come Ready to Enjoy Camp' }}</h2>
    <div class="w-full max-w-4xl mx-auto mb-24 flex justify-center">
        <div class="max-w-md text-center">
            @if($campPage?->step_5_sections && count($campPage->step_5_sections) > 0)
                @foreach($campPage->step_5_sections as $index => $section)
                    <h3 class="font-heading text-3xl text-secondary {{ $index > 0 ? 'mt-6' : '' }} flex justify-center items-center">
                        @if($index == 0)
                            <x-tabler-direction-arrows class="size-8 mr-2" />
                        @elseif($index == 1)
                            <x-tabler-list-check class="size-8 mr-2" />
                        @elseif($index == 2)
                            <x-tabler-ball-football class="size-8 mr-2" />
                        @endif
                        {{ $section['title'] }}
                    </h3>

                    <p class="text-lg {{ $index == 0 ? 'mb-4' : '' }}">
                        @if($section['link_url'] && $section['link_text'] && $index == 0)
                            Indian Creek is close by, but its still a camp - finding it can be tricky if you don't know where you are going. Click the map below or <a href="{{ $section['link_url'] }}" target="_blank" class="underline text-secondary">{{ $section['link_text'] }}</a> to get directions.
                        @else
                            {{ $section['content'] }}
                        @endif
                    </p>

                    @if($index == 0 && $section['link_url'])
                        <a href="{{ $section['link_url'] }}" target="_blank">
                            <img src="/map.png" alt="">
                        </a>
                    @endif

                    @if($section['link_url'] && $section['link_text'] && $index == 1)
                        <a href="{{ $section['link_url'] }}" target="_blank" class="w-full bg-accent hover:bg-red-900 shadow hover:shadow-none py-3 px-6 font-heading font-bold text-2xl flex justify-center items-center text-center text-white mt-6 rounded-full mr-0">
                            <x-tabler-file-download class="size-6 text-white mr-2" />
                            {{ $section['link_text'] }}</a>
                    @endif
                @endforeach
            @endif
        </div>


    </div>

</div>
