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

    {{-- Tabs Root --}}
    <div
        x-data="tabsComponent()"
        x-init="init()"
        class="my-6"
    >
        {{-- Mobile Tabs --}}
        <div class="sm:hidden">
            <select
                x-model="activeTab"
                class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand"
            >
                <template x-for="tab in tabs" :key="tab.key">
                    <option :value="tab.key" x-text="tab.label"></option>
                </template>
            </select>
        </div>

        {{-- Desktop Tabs --}}
        <ul class="hidden sm:flex text-sm font-medium text-center text-body -space-x-px">
            <template x-for="(tab, index) in tabs" :key="tab.key">
                <li class="w-full">
                    <button
                        type="button"
                        @click="setTab(tab.key)"
                        :class="tabButtonClass(index, tab.key)"
                        class="inline-flex items-center justify-center w-full border border-default px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand"
                    >
                        <span x-text="tab.label"></span>
                    </button>
                </li>
            </template>
        </ul>

        {{-- Tab Content --}}
        <div class="mt-6">
            <template x-if="activeTab === 'profile'">
                <livewire:organization.tabs.profile
                    :organization="$organization"
                    wire:key="profile-{{ $organization->id }}"
                />
            </template>

            <template x-if="activeTab === 'dashboard'">
                
            </template>

            <template x-if="activeTab === 'settings'">
                
            </template>

            <template x-if="activeTab === 'invoice'">
                
            </template>
        </div>
    </div>

    {{-- Alpine Component --}}
    <script>
        function tabsComponent() {
            return {
                activeTab: 'profile',

                tabs: [
                    { key: 'profile', label: 'Profile' },
                    { key: 'dashboard', label: 'Dashboard' },
                    { key: 'settings', label: 'Settings' },
                    { key: 'invoice', label: 'Invoice' },
                ],

                init() {
                    const urlTab = new URLSearchParams(window.location.search).get('tab');
                    this.activeTab = urlTab ?? localStorage.getItem('org-active-tab') ?? 'profile';
                },

                setTab(tab) {
                    this.activeTab = tab;
                    localStorage.setItem('org-active-tab', tab);

                    const url = new URL(window.location);
                    url.searchParams.set('tab', tab);
                    window.history.replaceState({}, '', url);
                },

                tabButtonClass(index, key) {
                    const base = 'font-medium leading-5 text-sm';

                    const active = this.activeTab === key
                        ? 'bg-neutral-secondary-medium text-heading'
                        : 'bg-neutral-primary-soft text-body hover:bg-neutral-secondary-medium';

                    const rounded =
                        index === 0
                            ? 'rounded-s-base'
                            : index === this.tabs.length - 1
                                ? 'rounded-e-base'
                                : '';

                    return `${base} ${active} ${rounded}`;
                },
            }
        }
    </script>
</x-layout>
