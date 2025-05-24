@extends('layouts.main')


@section('content')
    <div class="bottom w-full md:px-12 pt-6 md:pt-12 pb-48 bg-base z-10 bg-bottom bg-no-repeat bg-contain" style="background-image: url('/landscape2.jpg');">
        <h2 class="w-full text-center mt-8 mb-24 text-6xl font-heading text-secondary shrink-0">Step 5: Come Ready to Enjoy Camp</h2>
        <div class="w-full max-w-4xl mx-auto mb-24 flex justify-center">
            <div class="max-w-md text-center">
                <h3 class="font-heading text-3xl text-secondary flex justify-center items-center"><x-tabler-direction-arrows" class="size-8 mr-2 /> Get to Camp</h3>

                <p class="text-lg mb-4">Indian Creek is close by, but its still a camp - finding it can be tricky if you don't know where you are going.  Click the map below or <a href="https://maps.app.goo.gl/N6jxLGrDyv1xpXoF6" target="_blank" class="underline text-secondary">visit this page</a> to get directions.</p>
                <a href="https://maps.app.goo.gl/N6jxLGrDyv1xpXoF6" target="_blank">
                    <img src="/map.png" alt="">
                </a>
                <h3 class="font-heading text-3xl text-secondary mt-6 flex justify-center items-center"><x-tabler-list-check" class="size-8 mr-2 /> Follow the Guidelines</h3>
                <p class="text-lg">Information about what to bring and how to act can be found at this link:</p>
                <a href="https://indiancreek.camp/coc.pdf" target="_blank" class="w-full bg-accent hover:bg-red-900 shadow hover:shadow-none py-3 px-6 font-heading font-bold text-2xl flex justify-center items-center text-center text-white mt-6 rounded-full mr-0">
                    <x-tabler-file-download" class="size-6 text-white mr-2 />
                    Download Code of Conduct</a>
                <h3 class="font-heading text-3xl text-secondary mt-6 flex justify-center items-center"><x-tabler-ball-football" class="size-8 mr-2 />Have a Blast</h3>
                <p class="text-lg">We want you to come, have fun, and grow closer to Jesus.  Start preparing your heart now for an amazing week of camp!</p>
            </div>


        </div>

    </div>


@endsection
