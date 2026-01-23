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
            <x-welcome />
        </div>
    </div>
</x-layout>