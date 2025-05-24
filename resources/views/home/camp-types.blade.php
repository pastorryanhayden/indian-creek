<div class="w-full p-6 md:p-12 grid grid-cols-12 gap-6 md:gap-8" style="background-image: url('/textures/green-waves.jpg');">
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
    @foreach($types as $type)
        @php
            $firstWeek = $weeks->where('type_id', $type->id)->first();
            $firstWeekId = $firstWeek ? (string) $firstWeek->id : '0';
        @endphp
    <a href="/camp-page?type={{$type->id}}&week={{$firstWeekId}}" class="bg-white col-span-full {{$type->featured ? 'md:col-span-6' : 'md:col-span-3'}} flex items-center justify-center text-center p-12  bg-center group relative" >
        <img src="{{ $type->image ? asset('storage/' . $type->image) : '/default-type.jpg' }}" alt="{{$type->name}}" class="absolute top-0 bottom-0 left-0 right-0 w-full object-cover h-full  saturate-10 shadow-2xl group-hover:saturate-100 group-hover:shadow-none">
        <div class="absolute top-0 bottom-0 left-0 right-0 w-full object-cover h-full z-10 bg-base opacity-65 group-hover:opacity-25 group-hover:bg-black"></div>
        <h4 class="font-heading text-6xl text-black group-hover:text-base z-20">{!! $type->formatted_name !!}</h4>
    </a>
    @endforeach

</div>
