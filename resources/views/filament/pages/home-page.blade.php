<x-filament-panels::page>
    <div class="grid grid-cols-2 gap-6">
    <x-filament-panels::form wire:submit="save">
    {{ $this->form }}

    <x-filament-panels::form.actions
        :actions="$this->getFormActions()"
    />
    </x-filament-panels::form>
        <div class="preview">
            <h2>Preview</h2>
            Some content
        </div>
    </div>
</x-filament-panels::page>
