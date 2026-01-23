@props([
    'title',
    'value',
    'subtitle' => null,
    'color' => 'blue',   // blue | green | red | gray
])

@php
$colors = [
    'blue' => [
        'bg' => 'bg-blue-100 dark:bg-blue-900',
        'text' => 'text-blue-600 dark:text-blue-300',
    ],
    'green' => [
        'bg' => 'bg-green-100 dark:bg-green-900',
        'text' => 'text-green-600 dark:text-green-300',
    ],
    'red' => [
        'bg' => 'bg-red-100 dark:bg-red-900',
        'text' => 'text-red-600 dark:text-red-300',
    ],
    'gray' => [
        'bg' => 'bg-gray-100 dark:bg-gray-700',
        'text' => 'text-gray-600 dark:text-gray-300',
    ],
];
@endphp

<div class="bg-neutral-primary-soft block max-w-sm p-6 border border-default rounded-base shadow-xs hover:bg-neutral-secondary-medium">

    <div class="flex items-center justify-between mb-4">
        <div>
            <h5 class="text-sm font-medium tracking-tight text-heading">
                {{ $title }}
            </h5>

            <p class="text-3xl font-semibold tracking-tight text-heading leading-8">
                {{ $value }}
            </p>

            @if($subtitle)
                <p class="mt-1 text-sm text-body">
                    {{ $subtitle }}
                </p>
            @endif
        </div>

        <span class="flex items-center justify-center
             w-14 h-14 rounded-xl
             {{ $colors[$color]['bg'] }} {{ $colors[$color]['text'] }}">
            {{ $icon ?? '' }}
        </span>

    </div>
    
</div>
