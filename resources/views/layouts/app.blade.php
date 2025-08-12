<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Roxy Hub') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100">
    <!-- Theme toggle button -->
    <button type="button" onclick="toggleTheme()" aria-label="Toggle theme"
            class="fixed top-4 right-4 z-50 inline-flex items-center gap-2 px-3 py-3 rounded-full border border-gray-300 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80 backdrop-blur text-sm font-medium shadow hover:shadow-md hover:bg-white dark:hover:bg-gray-800">
        <svg class="w-4 h-4 hidden dark:block" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
        </svg>
        <svg class="w-4 h-4 dark:hidden" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path
                d="M6.76 4.84l-1.8-1.79L3.17 4.84 4.96 6.63 6.76 4.84zm10.48 14.32l1.79 1.8 1.79-1.8-1.79-1.79-1.79 1.79zM12 4V1h-0v3h0zm0 19v-3h0v3h0zM4 12H1v0h3v0zm19 0h-3v0h3v0zM6.76 19.16l-1.8 1.79 1.79 1.8 1.79-1.8-1.79-1.79zM17.24 4.84l1.8-1.79-1.79-1.8-1.79 1.8 1.79 1.79zM12 7a5 5 0 100 10 5 5 0 000-10z" />
        </svg>
    </button>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        @livewireScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />
    </body>
</html>
