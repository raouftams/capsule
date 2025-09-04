<div class="mb-6 flex flex-wrap items-center gap-4">
    <!-- Search -->
    <div class="flex-1 min-w-[200px]">
        <x-filament::input.wrapper class="w-full">
            <x-filament::input type="text" wire:model.live.debounce.500ms="search"
                placeholder="{{ __('filament.favorites.search') }}" icon="heroicon-o-magnifying-glass" />
        </x-filament::input.wrapper>
    </div>

    <!-- Per page -->
    <div class="w-40">
        <x-filament::input.wrapper class="w-full">
            <x-filament::input.select wire:model.live="perPage" class="w-full">
                <option value="12">{{ __('filament.pagination.per_page', ['count' => 12]) }}</option>
                <option value="24">{{ __('filament.pagination.per_page', ['count' => 24]) }}</option>
                <option value="48">{{ __('filament.pagination.per_page', ['count' => 48]) }}</option>
            </x-filament::input.select>
        </x-filament::input.wrapper>
    </div>
</div>