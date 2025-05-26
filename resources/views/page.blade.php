@extends('layouts.main')


@section('content')
    <div class="w-full md:px-12 min-h-screen pt-6 md:pt-12 pb-48 bg-base z-10 bg-bottom bg-no-repeat bg-contain" style="background-image: url('/landscape2.jpg');">
        <section class="block w-full max-w-4xl mx-auto">
        @include('partials.breadcrumbs')
            <h1 class="font-heading text-6xl mt-4 mx-auto">{{$page->title}}</h1>
            @if(@isset($page->image))
            <img src="{{asset($page->image)}}" class="w-full mx-auto mt-4">
            @endif

            <div class="prose p-6 bg-white w-full max-w-4xl mx-auto mt-4">
                {!! $page->content !!}
            </div>
        </section>

    </div>


@endsection
