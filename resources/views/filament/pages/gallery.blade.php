<x-filament-panels::page>
    <x-filament-panels::header heading="" subheading="{{ __('filament.gallery.description') }}" />

    <!-- Search Bar -->
    <x-search-per-page />


    <!-- Loading State -->
    @if(empty($images) && empty($search))
        <div class="text-center py-12">
            <x-filament::loading-indicator class="w-8 h-8 mx-auto mb-4" />
            <p class="text-gray-500 dark:text-gray-400">{{ __('filament.gallery.loading') }}</p>
        </div>
    @endif

    <div x-data="{ enlarged: false, currentImage: null }" class="relative">
        <!-- Image Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($images as $image)
                <x-image-card :image="$image" wire:key="image-{{ $image['id'] }}-{{ $image['source'] }}">
                    <x-slot name="actions">
                        <div class="flex justify-between items-center mt-auto">
                            @php
                                $isFavorited = auth()->user()->favorites()
                                    ->where('imageable_id', $image['id'])
                                    ->where('imageable_type', $image['source'])
                                    ->exists();
                            @endphp

                            <!-- Favorite -->
                            <button wire:click="toggleFavorite('{{ json_encode($image) }}')"
                                class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                title="{{ $isFavorited ? __('filament.gallery.unfavorite') : __('filament.gallery.add_favorite') }}">
                                <x-heroicon-o-heart
                                    class="w-5 h-5 {{ $isFavorited ? 'text-red-500 fill-current' : 'text-gray-400 dark:text-gray-300' }}" />
                            </button>

                            <!-- Download -->
                            <button wire:click="downloadImage(@js($image['url']), @js($image['title']))"
                                class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                title="{{ __('filament.gallery.download') }}">
                                <x-heroicon-o-arrow-down-tray class="w-5 h-5 text-gray-400 dark:text-gray-300" />
                            </button>
                        </div>
                    </x-slot>
                </x-image-card>
            @endforeach
        </div>

        <template x-if="enlarged && currentImage">
            <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4"
                @click.self="enlarged = false" x-transition>
                <img :src="currentImage.url" :alt="currentImage.title"
                    class="max-w-full max-h-[90vh] rounded-lg shadow-2xl transition-transform duration-300 scale-100 hover:scale-105" />
            </div>
        </template>
    </div>


    <!-- Pagination -->
    @if(!empty($pagination) && ($pagination['total_pages'] ?? 0) > 1)
        <x-pagination :current-page="$pagination['current_page']" :total-pages="$pagination['total_pages']"
            wire:key="gallery-pagination" />
    @endif



    <!-- No Results -->
    @if(empty($images) && !empty($search))
        <div class="text-center py-12">
            <x-heroicon-o-magnifying-glass class="w-12 h-12 text-gray-400 mx-auto mb-4" />
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                {{ __('filament.gallery.not_found_title') }}</h3>
            <p class="text-gray-500 dark:text-gray-400">{{ __('filament.gallery.not_found_description') }}</p>
        </div>
    @endif
</x-filament-panels::page>