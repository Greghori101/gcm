<x-filament-widgets::widget>
    <x-filament::section>
        <x-filament-actions::modals />
        <form wire:submit="create">
            {{ $this->form }}

            <x-filament::button form="create" type="submit" class="mt-3">
                {{ __('filament-panels::resources/pages/create-record.form.actions.create.label') }}
            </x-filament::button>
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
