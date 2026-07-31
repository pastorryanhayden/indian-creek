<div class="w-full p-6 md:p-12 grid grid-cols-12 gap-6 md:gap-8" style="background-image: url('/textures/green-waves.jpg');">
    @foreach($types as $type)
        @php
            $firstWeek = $weeks->where('type_id', $type->id)->first();
            $firstWeekId = $firstWeek ? (string) $firstWeek->id : '0';
        @endphp
        <a
            href="/camp-page?type={{ $type->id }}&week={{ $firstWeekId }}"
            class="bg-white col-span-full {{ $type->featured ? 'md:col-span-6' : 'md:col-span-3' }} flex items-center justify-center text-center p-12 bg-center group relative overflow-hidden"
        >
            <img
                src="{{ $type->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($type->image) : '/default-type.jpg' }}"
                alt="{{ $type->name }}"
                class="absolute inset-0 w-full h-full object-cover saturate-50 shadow-2xl transition-[filter,transform,box-shadow] duration-700 ease-out will-change-transform group-hover:saturate-100 group-hover:scale-105 group-hover:shadow-none group-active:scale-[1.02] group-active:duration-200"
            >
            <div
                class="absolute inset-0 z-10 bg-base/60 transition-[background-color,opacity] duration-700 ease-out group-hover:bg-black/30 group-active:bg-black/35"
            ></div>
            <h4 class="font-heading text-6xl text-black z-20 transition-colors duration-500 ease-out group-hover:text-base">
                {!! $type->formatted_name !!}
            </h4>
        </a>
    @endforeach
</div>
