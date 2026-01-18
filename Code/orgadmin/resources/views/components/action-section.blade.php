<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6 md:gap-8']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="px-6 py-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200">
            <div class="space-y-4">
                {{ $content }}
            </div>
        </div>
    </div>
</div>
