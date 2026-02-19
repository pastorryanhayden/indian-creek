@if(session('success'))
    <div class="alert admin-alert-success mb-6 rounded-lg shadow-sm flex items-start gap-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <x-tabler-check class="w-5 h-5 flex-shrink-0 mt-0.5" />
        <div class="flex-1">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        <button @click="show = false" class="flex-shrink-0 hover:opacity-70 transition-opacity">
            <x-tabler-x class="w-5 h-5" />
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert admin-alert-error mb-6 rounded-lg shadow-sm flex items-start gap-3" x-data="{ show: true }" x-show="show">
        <x-tabler-alert-circle class="w-5 h-5 flex-shrink-0 mt-0.5" />
        <div class="flex-1">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
        <button @click="show = false" class="flex-shrink-0 hover:opacity-70 transition-opacity">
            <x-tabler-x class="w-5 h-5" />
        </button>
    </div>
@endif

@if($errors->any())
    <div class="alert admin-alert-error mb-6 rounded-lg shadow-sm flex items-start gap-3" x-data="{ show: true }" x-show="show">
        <x-tabler-alert-triangle class="w-5 h-5 flex-shrink-0 mt-0.5" />
        <div class="flex-1">
            <p class="font-semibold mb-1">Please fix the following errors:</p>
            <ul class="list-disc list-inside text-sm space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button @click="show = false" class="flex-shrink-0 hover:opacity-70 transition-opacity">
            <x-tabler-x class="w-5 h-5" />
        </button>
    </div>
@endif
