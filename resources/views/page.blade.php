@extends('layouts.main')


@section('content')
    <div class="w-full md:px-12 min-h-screen pt-6 md:pt-12 pb-48 bg-base z-10 bg-bottom bg-no-repeat bg-contain" style="background-image: url('/landscape2.jpg');">
        <section class="max-w-3xl mx-auto">
        @include('partials.breadcrumbs')
            <h1 class="font-heading text-6xl mt-4">{{$page->title}}</h1>

            <div class="prose p-6 bg-white">
                {!! Str::markdown($page->content) !!}
            </div>
        </section>

    </div>


@endsection
