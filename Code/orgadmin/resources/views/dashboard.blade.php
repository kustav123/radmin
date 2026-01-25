<x-layout :breadcrumbs="[
        ['label' => 'Home', 'href' => route('dashboard')],
        ['label' => 'Dashboard']
    ]">
    <x-slot name="header">
        <h2 class="text-3xl font-bold tracking-tight text-bidy md:text-4xl">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            @if (tenant('id'))
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="mt-8 text-2xl font-medium text-gray-900">
                        Welcome to {{ tenant('id') }} Dashboard
                    </h1>
                </div>
                <livewire:tenant.dashboard-stats />
            @else
                <x-welcome />
            @endif
        </div>
    </div>
</x-layout>