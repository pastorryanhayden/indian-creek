<div class="bottom top w-full md:px-12 pt-6 md:pt-12 pb-24 bg-black text-white">
    <h2 class="w-full text-center my-8 text-6xl font-heading text-base shrink-0">Step 2: Choose Week</h2>
    <div class="flex w-full flex-wrap gap-6 justify-center">
        @foreach ($weeks as $week)
            @foreach ($week->speakers as $speaker)
                <button class="flex flex-col items-center w-42 shrink-0"
                        @click="type = '{{ $week->type_id }}'; week = '{{ $week->id }}'; updateQueryParams()"
                        :class="week == '{{ $week->id }}' ? '' : 'opacity-40'"
                        x-show="type == '{{ $week->type_id }}'">
                    <div class="relative w-full h-48 overflow-hidden" style="clip-path: polygon(20% 0%, 100% 0%, 80% 100%, 0% 100%)">
                        <img src="{{ $speaker->image ? asset('storage/' . $speaker->image) : '/default-speaker.jpg' }}"
                             alt="{{ $speaker->name }}"
                             class="w-full h-full object-cover {{ $speaker->name === 'Abdel Judeh' ? 'object-top' : '' }}">
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
                        <h3 class="text-3xl md:text-5xl font-bold font-heading md:leading-12">
                            {{ explode(' ', $speaker->name)[0] }} <br>{{ explode(' ', $speaker->name)[1] ?? '' }}
                        </h3>
                    </div>
                </button>
            @endforeach
        @endforeach
    </div>
    @foreach ($weeks as $week)
        <p class="text-2xl text-base text-center max-w-md mx-auto mt-12"
               x-show="week == '{{ $week->id }}'">
                @if ($week->status == 'almost full')
                    <span class="block font-bold text-accent">Almost Full</span>
                @endif
                    @if ($week->status == 'full')
                        <span class="block font-bold text-accent">At Capacity - Registration Closed</span>
                    @endif
</p>
        @foreach ($week->speakers as $speaker)
            <p class="text-2xl text-base text-center max-w-md mx-auto mt-12"
               x-show="week == '{{ $week->id }}'">
               
                {{ $speaker->bio }}
            </p>
        @endforeach
    @endforeach
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
         class="text-base size-10 block mt-2 mx-auto">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M12 5v.5m0 3v1.5m0 3v6" />
        <path d="M18 13l-6 6" />
        <path d="M6 13l6 6" />
    </svg>
</div>
