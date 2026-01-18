@props(['title' => __('Confirm Password'), 'content' => __('For your security, please confirm your password to continue.'), 'button' => __('Confirm')])

@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<span
    {{ $attributes->wire('then') }}
    x-data
    x-ref="span"
    x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
    x-on:password-confirmed.window="setTimeout(() => $event.detail.id === '{{ $confirmableId }}' && $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })), 250);"
>
    {{ $slot }}
</span>

@once
<x-dialog-modal wire:model.live="confirmingPassword">
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="content">
        <p class="text-sm text-fg-neutral-medium dark:text-fg-neutral-medium">
            {{ $content }}
        </p>

        <div class="mt-6" x-data="{}" x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
            <label for="confirmable_password" class="block text-sm font-semibold text-fg-brand-strong dark:text-fg-brand-softer mb-2">
                {{ __('Password') }}
            </label>
            <input 
                id="confirmable_password"
                type="password" 
                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent transition-colors duration-200"
                placeholder="{{ __('Enter your password') }}" 
                autocomplete="current-password"
                x-ref="confirmable_password"
                wire:model="confirmablePassword"
                wire:keydown.enter="confirmPassword" 
            />

            <x-input-error for="confirmable_password" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <div class="flex items-center gap-3 justify-end">
            <button type="button" wire:click="stopConfirmingPassword" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed">
                {{ __('Cancel') }}
            </button>

            <button type="button" dusk="confirm-password-button" wire:click="confirmPassword" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-2.5 bg-brand hover:bg-brand-strong text-white text-sm font-semibold rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md">
                {{ $button }}
            </button>
        </div>
    </x-slot>
</x-dialog-modal>
@endonce

