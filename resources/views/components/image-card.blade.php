<div x-data="{ loading: true, hasError: false }"
    class="rounded-2xl shadow-md overflow-hidden bg-white dark:bg-gray-800 hover:shadow-xl transition-shadow">
    <!-- Image Container -->
    <div class="relative aspect-square bg-gray-100 dark:bg-gray-700 cursor-pointer"
        @click="enlarged = true; currentImage = { url: @js($image['url']), title: @js($image['title']) }">

        <!-- Loading placeholder -->
        <div x-show="loading" x-transition class="absolute inset-0 flex items-center justify-center">
            <x-filament::loading-indicator class="w-6 h-6 text-gray-400" />
        </div>

        <!-- Error State -->
        <div x-show="hasError" class="absolute inset-0 flex items-center justify-center bg-gray-200 dark:bg-gray-600">
            <x-heroicon-o-photo class="w-8 h-8 text-gray-400" />
        </div>

        <!-- Image -->
        @if($image['valid'] ?? true && $image['url'])
            <img src="{{ $image['url'] }}" alt="{{ $image['title'] }}" x-on:load="loading = false; hasError = false"
                x-on:error="loading = false; hasError = true" x-init="
                                                        if ($el.complete && $el.naturalHeight !== 0) {
                                                            loading = false; 
                                                            hasError = false;
                                                        }
                                                    " class="w-full h-full object-cover transition-transform duration-300"
                x-show="!loading && !hasError" />
        @else
            <div x-init="loading = false" class="flex items-center justify-center w-full h-full text-gray-400 bg-gray-200 dark:bg-gray-700">
                <x-heroicon-o-photo class="w-10 h-10" />
            </div>
        @endif
    </div>

    <!-- Content -->
    <div class="p-4">
        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2 line-clamp-2" :title="@js($image['title'])">
            {{ $image['title'] }}
        </h3>

        {{ $actions ?? '' }}

    </div>
</div>