<x-filament-panels::page>
    <x-filament-panels::header heading="" subheading="{{ __('filament.favorites.description') }}" />

    <!-- Search & Per Page -->
    <x-search-per-page />

    <!-- Loading State -->
    @if($this->getFavorites()->isEmpty() && empty($search))
        <div class="text-center py-12">
            <x-filament::loading-indicator class="w-8 h-8 mx-auto mb-4" />
            <p class="text-gray-500 dark:text-gray-400">{{ __('filament.favorites.empty') }}</p>
        </div>
    @endif

    <!-- Grid -->
    <div x-data="{ enlarged: false, currentImage: null }" class="relative">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($this->getFavorites() as $image)
                <x-image-card :image="$image" wire:key="favorite-{{ $image['favorite_id'] }}-{{ $image['id'] }}">
                    <x-slot name="actions">
                        <div class="flex justify-between items-center">
                            <!-- Favorite -->
                            <button wire:click="toggleFavorite('{{ $image['favorite_id'] }}')"
                                class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                title="{{ __('filament.favorites.unfavorite') }}">
                                <x-heroicon-o-heart class="w-5 h-5 text-red-500 fill-current" />
                            </button>

                            <!-- Download -->
                            @if($image['valid'] && $image['url'])
                                <button wire:click="downloadImage(@js($image['url']), @js($image['title']))"
                                    class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                    title="{{ __('filament.favorites.download') }}">
                                    <x-heroicon-o-arrow-down-tray class="w-5 h-5 text-gray-400 dark:text-gray-300" />
                                </button>
                            @endif
                        </div>
                    </x-slot>
                </x-image-card>
            @endforeach
        </div>

        <!-- Modal enlarged image -->
        <template x-if="enlarged && currentImage">
            <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4"
                @click.self="enlarged = false" x-transition>
                <img :src="currentImage.url" :alt="currentImage.title"
                    class="max-w-full max-h-[90vh] rounded-lg shadow-2xl transition-transform duration-300 scale-100 hover:scale-105" />
            </div>
        </template>
    </div>

    <!-- Pagination -->
    @php
        $pagination = $this->getFavorites();
        $totalPages = $pagination->lastPage();
        $currentPage = $pagination->currentPage();
    @endphp
    @if($totalPages > 1)
        <x-pagination :current-page="$currentPage" :total-pages="$totalPages" wire:key="favorites-pagination" />
    @endif
</x-filament-panels::page>