<div class="w-full md:px-12 pt-6 md:pt-12 pb-64 bg-bottom bg-no-repeat bg-contain bg-brand-green z-20" style="background-image: url('/landscape.png');">
    <h2 class="w-full text-center my-8 text-6xl font-heading text-base shrink-0">2027 Camp Speakers</h2>
    <div
        class="flex w-full flex-wrap gap-6 justify-center"
        x-data="{ hoveredWeek: null }"
        @mouseleave="hoveredWeek = null"
    >
        @foreach ($weeks as $week)
            @foreach ($week->speakers as $speaker)
                <a
                    class="flex flex-col items-center w-42 shrink-0 transition-opacity duration-500 ease-out"
                    href="/camp-page?type={{ $week->type_id }}&week={{ $week->id }}"
                    data-week-id="{{ $week->id }}"
                    @mouseenter="hoveredWeek = {{ $week->id }}"
                    @focus="hoveredWeek = {{ $week->id }}"
                    @blur="hoveredWeek = null"
                    :class="hoveredWeek !== null && hoveredWeek !== {{ $week->id }} ? 'opacity-25' : 'opacity-100'"
                >
                    <div class="relative w-full h-48 overflow-hidden" style="clip-path: polygon(20% 0%, 100% 0%, 80% 100%, 0% 100%)">
                        <img
                            src="{{ $speaker->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($speaker->image) : '/default-speaker.jpg' }}"
                            alt="{{ $speaker->name }}"
                            class="w-full h-full object-cover"
                        >
                        @if ($week->status == 'full' || $week->status == 'almost full')
                            <div class="stamp">
                                {{ $week->status == 'full' ? 'FULL' : 'Almost Full' }}
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 text-right text-base">
                        <p class="text-lg md:text-xl">{{ $week->name }}</p>
                        <p class="text-lg md:text-xl">
                            {{ $week->start_date->format('F j') }}-{{ $week->start_date->month === $week->end_date->month ? $week->end_date->format('j') : $week->end_date->format('F j') }}
                        </p>
                        <h3 class="text-3xl md:text-5xl font-bold font-heading md:leading-12">{!! $speaker->formatted_name !!}</h3>
                    </div>
                </a>
            @endforeach
        @endforeach
    </div>
    <div class="col-span-full p-6 md:p-12 flex justify-center">
        <a href="/camp-page" class="bg-brand-red text-white py-4 px-6 rounded-full text-4xl font-heading hover:brightness-75">Explore 2027 Camps</a>
    </div>
</div>
