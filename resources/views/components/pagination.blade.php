<div class="mt-8 flex justify-center items-center gap-6 flex-wrap">
    <!-- Previous -->
    <div>
        <x-filament::button 
            wire:click="previousPage" 
            :disabled="$currentPage <= 1" 
            icon="{{ session('locale') == 'ar' ? 'heroicon-o-arrow-right' : 'heroicon-o-arrow-left' }}"
            class="px-4"
        >
            {{ __('filament.pagination.previous') }}
        </x-filament::button>
    </div>

    <!-- Page Numbers -->
    <div class="flex items-center gap-2">
        @for ($i = 1; $i <= min(5, $totalPages); $i++)
            <x-filament::button 
                wire:click="gotoPage({{ $i }})"
                color="{{ $currentPage == $i ? 'primary' : 'secondary' }}" 
                class="w-10 h-10"
            >
                {{ $i }}
            </x-filament::button>
        @endfor

        @if ($totalPages > 6)
            <span class="px-2 text-gray-500">…</span>
            <x-filament::button 
                wire:click="gotoPage({{ $totalPages }})"
                color="{{ $currentPage == $totalPages ? 'primary' : 'secondary' }}" 
                class="w-10 h-10"
            >
                {{ $totalPages }}
            </x-filament::button>
        @endif
    </div>

    <!-- Next -->
    <div>
        <x-filament::button 
            wire:click="nextPage" 
            :disabled="$currentPage >= $totalPages"
            icon="{{ session('locale') == 'ar' ? 'heroicon-o-arrow-left' : 'heroicon-o-arrow-right' }}"
            icon-position="after" 
            class="px-4"
        >
            {{ __('filament.pagination.next') }}
        </x-filament::button>
    </div>
</div>
