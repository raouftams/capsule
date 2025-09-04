<div x-data="{ open: false }" class="relative p-2 my-auto">
    <button @click="open = !open" type="button"
        class="p-2 rounded-lg bg-transparent text-sm font-medium focus:ring-2 focus:ring-primary-500 focus:outline-none">
        
        @if(app()->isLocale('en'))
            <x-flag-language-en class="w-6 h-6" />
        @elseif(app()->isLocale('ar'))
            <x-flag-language-ar class="w-6 h-6" />
        @endif
    </button>

    <div x-show="open" @click.outside="open = false" x-transition
        class="absolute mt-2 rounded-lg shadow-lg bg-white dark:bg-gray-800 border z-50"
        x-cloak>
        
        <!-- English -->
        <form method="POST" action="{{ route('locale.switch') }}">
            @csrf
            <input type="hidden" name="locale" value="en">
            <button type="submit"
                class="p-2 rounded-lg text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                <x-flag-language-en class="w-5 h-5" />
            </button>
        </form>

        <!-- Arabic -->
        <form method="POST" action="{{ route('locale.switch') }}">
            @csrf
            <input type="hidden" name="locale" value="ar">
            <button type="submit"
                class="p-2 rounded-lg text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                <x-flag-language-ar class="w-5 h-5" />
            </button>
        </form>
    </div>
</div>
