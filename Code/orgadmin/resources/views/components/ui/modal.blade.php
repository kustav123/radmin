@props([
    'id',
    'title' => null,
    'maxWidth' => 'max-w-2xl',
])

<div
    x-show="open"
    x-transition
    x-cloak
    id="{{ $id }}"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    @keydown.escape.window="open = false"
>
    <div class="relative w-full {{ $maxWidth }} p-4">
        <div class="bg-neutral-primary-soft border border-default rounded-base shadow-sm">

            {{-- Header --}}
            @if($title)
                <div class="flex items-center justify-between border-b border-default px-4 py-4 md:px-6">
                    <h3 class="text-lg font-medium text-heading">
                        {{ $title }}
                    </h3>

                    <button
                        type="button"
                        @click="open = false"
                        class="text-body hover:bg-neutral-tertiary rounded-base w-9 h-9 inline-flex justify-center items-center"
                    >
                        ✕
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
            @endif

            {{-- Body --}}
            <div class="px-4 py-4 md:px-6 md:py-6">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            @isset($footer)
                <div class="flex items-center justify-end gap-3 border-t border-default px-4 py-4 md:px-6">
                    {{ $footer }}
                </div>
            @endisset

        </div>
    </div>
</div>
