<div>

    {{-- Mobile (Select) --}}
    <div class="sm:hidden mb-6">
        <label for="tabs" class="sr-only">Select tab</label>
        <select
            id="tabs"
            wire:model="activeTab"
            class="block w-full bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs px-3 py-2.5"
        >
            <option value="profile">Profile</option>
            <option value="store">Store</option>
            <option value="settings">Settings</option>
            <option value="invoice">Invoice</option>
        </select>
    </div>

    {{-- Desktop Tabs --}}
    <ul class="hidden sm:flex text-sm font-medium text-center text-body -space-x-px mb-6">

        {{-- Profile --}}
        <li class="w-full focus-within:z-10">
            <button
                wire:click="setTab('profile')"
                class="inline-flex items-center justify-center w-full border px-4 py-2.5 rounded-s-base
                {{ $activeTab === 'profile'
                    ? 'bg-neutral-secondary-medium text-heading border-brand'
                    : 'bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium hover:text-heading' }}"
            >
                <svg class="w-4 h-4 me-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"/>
                </svg>
                Profile
            </button>
        </li>

        {{-- Store --}}
        <li class="w-full focus-within:z-10">
            <button
                wire:click="setTab('store')"
                class="inline-flex items-center justify-center w-full border px-4 py-2.5
                {{ $activeTab === 'store'
                    ? 'bg-neutral-secondary-medium text-heading border-brand'
                    : 'bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium hover:text-heading' }}"
            >
                <svg class="w-4 h-4 me-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z"/>
                </svg>
                Store
            </button>
        </li>

        {{-- Settings --}}
        <li class="w-full focus-within:z-10">
            <button
                wire:click="setTab('settings')"
                class="inline-flex items-center justify-center w-full border px-4 py-2.5
                {{ $activeTab === 'settings'
                    ? 'bg-neutral-secondary-medium text-heading border-brand'
                    : 'bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium hover:text-heading' }}"
            >
                <svg class="w-4 h-4 me-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                Settings
            </button>
        </li>

        {{-- Invoice --}}
        <li class="w-full focus-within:z-10">
            <button
                wire:click="setTab('invoice')"
                class="inline-flex items-center justify-center w-full border px-4 py-2.5 rounded-e-base
                {{ $activeTab === 'invoice'
                    ? 'bg-neutral-secondary-medium text-heading border-brand'
                    : 'bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium hover:text-heading' }}"
            >
                <svg class="w-4 h-4 me-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" d="M6 2h9l3 3v17H6z"/>
                </svg>
                Invoice
            </button>
        </li>

    </ul>

    {{-- Tab Content --}}
    <div class="mt-4">
        @if ($activeTab === 'profile')
            <livewire:organization.tabs.profile :organization="$organization" />
        @elseif ($activeTab === 'store')
            <livewire:organization.tabs.store :organization="$organization" />
        @elseif ($activeTab === 'settings')
            <livewire:organization.tabs.settings :organization="$organization" />
        @elseif ($activeTab === 'invoice')
            <livewire:organization.tabs.invoice :organization="$organization" />
        @endif
    </div>

</div>
