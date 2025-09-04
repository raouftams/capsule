<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      class="h-full bg-gray-50 dark:bg-gray-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Capsule</title>

</head>
<body class="h-full antialiased text-gray-800 dark:text-gray-100">

    <!-- Top Bar with Language Switcher -->
    <header class="w-full border-b border-gray-200 dark:border-gray-900 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto flex justify-end">
            <x-language-switcher />
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6 md:py-4 lg:py-6 lg:px-8 flex flex-col lg:flex-row items-center gap-12">
            
            <!-- Left Content -->
            <div class="flex-1">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl lg:text-6xl">
                    {{ __('frontend.title', ['institute' => 'Chicago Institute']) }}
                </h1>
                <p class="mt-6 text-lg text-gray-600 dark:text-gray-300 max-w-2xl">
                    {{ __('frontend.subtitle') }}
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('filament.user.auth.login') }}"
                       class="px-6 py-3 rounded-lg bg-primary-600 text-white font-semibold shadow hover:bg-primary-700 transition">
                        {{ __('frontend.login') }}
                    </a>
                    <a href="{{ route('filament.user.auth.register') }}"
                       class="px-6 py-3 rounded-lg border border-primary-600 text-primary-600 dark:text-primary-400 font-semibold hover:bg-primary-50 dark:hover:bg-gray-800 transition">
                        {{ __('frontend.register') }}
                    </a>
                </div>
            </div>

            <!-- Right Image -->
            <div class="flex-1 flex justify-center">
                <img src="https://www.artic.edu/iiif/2/3c27b499-af56-f0d5-93b5-a7f2f1ad5813/full/843,/0/default.jpg" 
                     alt="Chicago Institute Artwork" 
                     class="rounded-xl shadow-lg w-full max-w-lg">
            </div>
        </div>
    </section>

</body>
</html>
