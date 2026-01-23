<div
    id="app-toast"
    class="fixed top-5 right-5 z-50 hidden w-full max-w-xs p-4
           text-gray-500 bg-white border border-gray-200 rounded-lg shadow
           dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
    role="alert"
>
    <div class="flex items-center">
        <div
            id="toast-icon"
            class="inline-flex items-center justify-center flex-shrink-0
                   w-8 h-8 rounded-lg"
        ></div>

        <div id="toast-message" class="ms-3 text-sm font-normal"></div>

        <button
            type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400
                   hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300
                   p-1.5 hover:bg-gray-100 inline-flex items-center justify-center
                   h-8 w-8 dark:text-gray-500 dark:hover:text-white
                   dark:bg-gray-800 dark:hover:bg-gray-700"
            onclick="hideToast()"
        >
            ✕
        </button>
    </div>
</div>
