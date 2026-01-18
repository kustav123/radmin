<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-200">
    <!-- Logo Section -->
    <div class="flex items-center justify-center mb-2">
        {{ $logo }}
    </div>

    <!-- Authentication Card -->
    <div class="w-full sm:max-w-md mt-8 px-6 py-8 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-xl transition-all duration-200 overflow-hidden">
        {{ $slot }}
    </div>
</div>
