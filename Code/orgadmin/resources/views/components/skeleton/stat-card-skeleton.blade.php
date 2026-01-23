<div role="status"
    class="bg-neutral-primary-soft block max-w-sm p-6 border border-default rounded-base shadow-xs animate-pulse">
    <div class="flex items-center justify-between mb-4">

        {{-- Left content --}}
        <div class="flex-1">
            {{-- Title --}}
            <div class="h-3 w-28 bg-neutral-quaternary rounded-full mb-2"></div>

            {{-- Value --}}
            <div class="h-8 w-20 bg-neutral-quaternary rounded-full mb-2"></div>

            {{-- Subtitle (optional placeholder) --}}
            <div class="h-3 w-36 bg-neutral-quaternary rounded-full"></div>
        </div>

        {{-- Icon placeholder --}}
        <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-neutral-quaternary">
            <svg class="w-6 h-6 text-fg-disabled" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 21a9 9 0 1 0 0-18" />
            </svg>
        </div>

    </div>

    <span class="sr-only">Loading...</span>
</div>