<div class="mb-6">
    <div class="flex items-start justify-between gap-6">
        <div class="flex-1">
            <h3 class="text-xl font-bold text-fg-brand-strong dark:text-fg-brand-softer leading-tight">
                {{ $title }}
            </h3>

            <p class="mt-2 text-sm text-fg-neutral-medium dark:text-fg-neutral-medium leading-relaxed max-w-2xl">
                {{ $description }}
            </p>
        </div>

        @if (isset($aside))
            <div class="flex-shrink-0 mt-1">
                {{ $aside }}
            </div>
        @endif
    </div>
</div>
