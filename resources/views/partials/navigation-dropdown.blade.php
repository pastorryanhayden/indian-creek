<div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-secondary">
    <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
        <x-dynamic-component :component="'tabler-' . $icon" class="size-6 text-gray-600 group-hover:text-accent" />
    </div>
    <div class="flex-auto">
        <a href="{{ $url }}" class="block font-semibold text-gray-900 group-hover:text-white">
            {{ $title }}
            <span class="absolute inset-0"></span>
        </a>
        <p class="mt-1 text-gray-600 group-hover:text-base">{{ $subtitle }}</p>
    </div>
</div>
