<x-filament-widgets::widget>
    <x-filament::section>
        <x-filament::card>

        {{ $this->form }}

        <x-filament::button wire:click="submit" id="cardButton" type="button" class="mt-6">
            {{ __('Ajouter') }}
        </x-filament::button>

    </x-filament::card>
    </x-filament::section>
    <x-filament-actions::modals />
</x-filament-widgets::widget>
