<x-layout :breadcrumbs="[
        ['label' => 'Home', 'href' => route('dashboard')],
        ['label' => 'Master Data'],
        ['label' => 'Organization']
    ]">
    <x-slot name="header">
        <x-ui.toast />
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
            <h2 class="text-3xl font-bold tracking-tight text-heading md:text-4xl">
                {{ __('Organization') }}
            </h2>
            <div class="flex gap-2">
                <button x-data @click="$dispatch('open-tree-modal')"
                    class="px-6 py-2.5 flex items-center gap-2 text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary-soft shadow-xs font-medium leading-5 rounded-full text-sm focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                        </path>
                    </svg>
                    Tree View
                </button>
                <button onclick="Livewire.dispatch('openOrganizationCrud')"
                    class="px-6 py-2.5 rounded-full shadow-md text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-base text-sm text-center leading-5">
                    + Create New Organization
                </button>
            </div>
        </div>
    </x-slot>

    <div class="my-6">
        <div class="space-y-6">

            {{-- Stats --}}
            <livewire:organization.organization-stats />

            {{-- Table --}}
            <livewire:organization.organization-table />

            {{-- CRUD Modal --}}
            <livewire:organization.organization-crud />

            {{-- Modal --}}
            <div x-data="{ open: false }" @open-tree-modal.window="open = true"
                @close-open-tree-modal.window="open = false">
                <x-ui.modal id="open-tree-modal" title="Organization Tree" maxWidth="max-w-lg">

                    {{-- BODY (default slot) --}}
                    <livewire:organization.organization-tree />

                    {{-- FOOTER SLOT --}}
                    <x-slot:footer>
                        <button @click="open = false"
                            class="px-4 py-2 text-body bg-neutral-secondary-medium border border-default rounded-base hover:bg-neutral-tertiary">
                            Cancel
                        </button>
                    </x-slot:footer>

                </x-ui.modal>
            </div>

            {{-- <livewire:organization-manager /> --}}

            

        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {

            Livewire.on('toast', (payload) => {
                const data = payload[0]; // 👈 IMPORTANT
                showToast(data.type, data.message);
            });

        });

        function showToast(type, message) {
            const toast = document.getElementById('app-toast');
            const icon = document.getElementById('toast-icon');
            const msg = document.getElementById('toast-message');

            msg.innerText = message;

            const styles = {
                success: {
                    icon: '✔',
                    bg: 'bg-green-100 text-green-500'
                },
                error: {
                    icon: '✖',
                    bg: 'bg-red-100 text-red-500'
                },
                warning: {
                    icon: '⚠',
                    bg: 'bg-yellow-100 text-yellow-500'
                }
            };

            icon.className = `inline-flex items-center justify-center w-8 h-8 rounded-lg ${styles[type].bg}`;
            icon.innerText = styles[type].icon;

            toast.classList.remove('hidden');

            setTimeout(() => hideToast(), 3000);
        }

        function hideToast() {
            document.getElementById('app-toast').classList.add('hidden');
        }
    </script>
</x-layout>