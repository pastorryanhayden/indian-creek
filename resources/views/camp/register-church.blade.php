<div class="bottom top w-full  md:px-12 pt-6 md:pt-12 pb-6 bg-base ">
    <h2 class="w-full text-center mt-8 mb-24 text-6xl font-heading text-secondary shrink-0">{{ $campPage?->step_3_title ?? 'Step 3:Register Your Church' }}</h2>
    <div class="w-full max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 mb-24 p-8 lg:p-0">
        <div>
            <h3 class="font-heading text-3xl text-secondary">Camper Registration FAQs</h3>
            @if($campPage?->step_3_faq && count($campPage->step_3_faq) > 0)
                @foreach($campPage->step_3_faq as $faq)
                <h4 class="font-bold text-xl mt-6">{{ $faq['question'] }}</h4>
                <p class="text-lg">{{ $faq['answer'] }}</p>
                @endforeach
            @endif
        </div>
        <div class="bg-black text-base p-6">
            @if($campPage?->step_3_info_text && count($campPage->step_3_info_text) > 0)
                @foreach($campPage->step_3_info_text as $index => $info)
                <p class="text-lg {{ $index > 0 ? 'mt-6' : '' }} {{ $index == 1 ? 'font-bold' : '' }}">{{ $info['paragraph'] }}</p>
                @endforeach
            @endif
            @if($campPage?->step_3_address)
            <p class="text-lg mt-6">{!! nl2br(e($campPage->step_3_address)) !!}</p>
            @endif
            @if($campPage?->step_3_download && $campPage?->step_3_download_content)
            <a href="{{ str_starts_with($campPage->step_3_download, 'http') ? $campPage->step_3_download : (str_starts_with($campPage->step_3_download, '/') ? $campPage->step_3_download : '/storage/' . $campPage->step_3_download) }}" target="_blank" class="w-full bg-accent hover:bg-red-900 shadow hover:shadow-none py-3 px-6 font-heading font-bold text-2xl flex justify-center items-center text-center text-white mt-6 rounded-full mr-0">
                <x-tabler-file-download class="size-6 text-white mr-2" />
                {{ $campPage->step_3_download_content }}</a>
            @endif
        </div>

    </div>
    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="text-black size-10 block mt-2 mx-auto"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5v.5m0 3v1.5m0 3v6" /><path d="M18 13l-6 6" /><path d="M6 13l6 6" /></svg>
</div>
