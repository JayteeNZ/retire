<x-filament-panels::page>
    <form wire:submit="registerJobSeeker">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getFormActions()"
            alignment="right"
        />
    </form>
</x-filament-panels::page>
