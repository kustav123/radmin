<x-layout
    :breadcrumbs="[
        ['label' => 'Home', 'href' => route('dashboard')],
        ['label' => 'Master Data'],
        ['label' => 'Organization', 'href' => route('organization')],
        ['label' => $organization->name],
    ]"
>
    <x-slot name="header">
        <x-ui.toast />

        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h2 class="text-3xl font-bold tracking-tight text-heading md:text-4xl">
                {{ __('Organization') }}
            </h2>
        </div>
    </x-slot>

    <!-- organization-tabs -->
    <livewire:organization.organization-tabs :organization="$organization" />

</x-layout>
