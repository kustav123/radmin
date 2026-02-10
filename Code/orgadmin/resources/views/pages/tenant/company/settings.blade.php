<x-layout
    :breadcrumbs="[
        ['label' => 'Home', 'href' => route('dashboard')],
        ['label' => 'Settings'],
    ]"
>
    <x-slot name="header">
        <x-ui.toast />

        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h2 class="text-3xl font-bold tracking-tight text-heading md:text-4xl">
                {{ __( $tenant->name) }}
            </h2>
        </div>
    </x-slot>

    <!-- organization-tabs -->
    <livewire:tenant.company.tabs :tenant="$tenant" />

</x-layout>
