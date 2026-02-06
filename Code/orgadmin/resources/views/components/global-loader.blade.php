<!-- Global Loading Backdrop -->
<div id="global-loader"
     {{ $attributes->merge([
        'class' =>
        'fixed inset-0 z-[9999] hidden items-center justify-center
         bg-neutral-primary-soft/50 backdrop-blur-sm'
     ]) }}>

    <div class="flex flex-col items-center gap-4">
        <!-- Spinner -->
        <svg class="w-14 h-14 text-indigo-600 dark:text-indigo-400 animate-spin"
             xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8v8z"></path>
        </svg>

        <p class="text-white text-sm tracking-wide">
            {{ $slot ?: 'Processing, please wait...' }}
        </p>
    </div>
</div>
