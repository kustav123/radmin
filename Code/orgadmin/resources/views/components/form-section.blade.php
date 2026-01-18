@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6 md:gap-8']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}" class="space-y-0">
            <!-- Form Content -->
            <div class="px-6 py-6 bg-white dark:bg-gray-800 rounded-t-lg border border-b-0 border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            <!-- Form Actions -->
            @if (isset($actions))
                <div class="flex items-center justify-between px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-700 rounded-b-lg shadow-sm">
                    {{ $actions }}
                </div>
            @else
                <div class="h-0.5 bg-gray-100 dark:bg-gray-700"></div>
            @endif
        </form>
    </div>
</div>
