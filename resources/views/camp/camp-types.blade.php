<div class="bottom top w-full pt-20 px-6 pb-8 md:px-12 flex flex-col items-center justify-center" style="background-image: url('/textures/green-waves.jpg');">
    <h2 class="text-6xl font-heading text-base mb-12">Step 1: Choose Camp Type</h2>
    <div class="w-full grid grid-cols-12 gap-6 md:gap-8">
        @foreach ($types as $type)
            @php
                $firstWeek = $weeks->where('type_id', $type->id)->first();
                $firstWeekId = $firstWeek ? (string) $firstWeek->id : '0';
                $colClass = $type->featured ? 'col-span-full md:col-span-6' : 'col-span-6 md:col-span-3';
            @endphp
            <button class="cursor-pointer bg-white {{ $colClass }} flex items-center justify-center text-center p-12 bg-center group relative"
                    :class="type == '{{ $type->id }}' && 'border-6 border-accent'"
                    @click="type = '{{ $type->id }}'; week = '{{ $firstWeekId }}'; updateQueryParams()">
                <img src="{{ $type->image ? asset('storage/' . $type->image) : '/default-type.jpg' }}"
                     alt="{{ $type->name }}"
                     class="absolute top-0 bottom-0 left-0 right-0 w-full object-cover h-full saturate-10 shadow-2xl group-hover:saturate-100 group-hover:shadow-none"
                     :class="type == '{{ $type->id }}' && 'saturate-100 shadow-none'">
                <div class="absolute top-0 bottom-0 left-0 right-0 w-full object-cover h-full z-10 bg-base opacity-65 group-hover:opacity-25 group-hover:bg-black"
                     :class="type == '{{ $type->id }}' && 'bg-black opacity-25'"></div>
                <h4 class="font-heading text-6xl text-black group-hover:text-base z-20"
                    :class="type == '{{ $type->id }}' && 'text-accent!'">
                    {!! $type->formatted_name !!}
                </h4>
            </button>
        @endforeach
    </div>
    @foreach ($types as $type)
        <p class="text-2xl max-w-md mx-auto mt-12 text-center text-base"
           x-show="type == '{{ $type->id }}'">
            {{ $type->description ?? 'No description available.' }}
        </p>
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
