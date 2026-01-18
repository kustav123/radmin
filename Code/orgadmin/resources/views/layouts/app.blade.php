<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="html-root">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Flowbite CDN (Modern Theme) -->
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.0.0/dist/flowbite.min.css" rel="stylesheet" />

        <!-- Dark Mode Initialization Script -->
        <script>
            // Initialize theme before page renders to avoid flashing
            (function() {
                const theme = localStorage.getItem('theme');
                const isDark = theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches);
                if (isDark) {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-200">
        <x-banner />

        <!-- Navbar -->
        @include('layouts.topbar')

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="p-4 sm:ml-64 mt-14">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="mb-6">
                    <div class="max-w-7xl">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        <!-- Flowbite JS (Modern) -->
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.0.0/dist/flowbite.min.js"></script>

        <!-- Dark Mode Toggle Script -->
        <script>
            // Define toggleTheme and make it available after Flowbite loads
            window.toggleTheme = function() {
                console.log('toggleTheme called');
                const htmlElement = document.documentElement;
                const isDark = htmlElement.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                console.log('Dark mode now:', isDark);
                
                // Toggle SVG icons visibility
                const darkIcon = document.getElementById('theme-toggle-dark-icon');
                const lightIcon = document.getElementById('theme-toggle-light-icon');
                
                if (darkIcon && lightIcon) {
                    if (isDark) {
                        darkIcon.classList.add('hidden');
                        lightIcon.classList.remove('hidden');
                    } else {
                        darkIcon.classList.remove('hidden');
                        lightIcon.classList.add('hidden');
                    }
                }
                
                // Dispatch custom event for other components
                window.dispatchEvent(new CustomEvent('themeChanged', { detail: { isDark } }));
            };

            // Initialize SVG icons on page load
            document.addEventListener('DOMContentLoaded', function() {
                const htmlElement = document.documentElement;
                const isDark = htmlElement.classList.contains('dark');
                const darkIcon = document.getElementById('theme-toggle-dark-icon');
                const lightIcon = document.getElementById('theme-toggle-light-icon');
                
                if (darkIcon && lightIcon) {
                    if (isDark) {
                        darkIcon.classList.add('hidden');
                        lightIcon.classList.remove('hidden');
                    } else {
                        darkIcon.classList.remove('hidden');
                        lightIcon.classList.add('hidden');
                    }
                }
            });

            // Listen for theme changes
            window.addEventListener('themeChanged', function(e) {
                console.log('Theme changed to:', e.detail.isDark ? 'dark' : 'light');
            });

            console.log('toggleTheme function initialized:', typeof window.toggleTheme);
        </script>

        @livewireScripts
    </body>
</html>
