<div>
    {{-- Tabs --}}
    <ul class="flex border-b mb-6 text-sm font-medium">
        @foreach(['profile', 'dashboard', 'settings', 'invoice'] as $tab)
            <li class="mr-2">
                <button
                    wire:click="setTab('{{ $tab }}')"
                    class="px-4 py-2 border-b-2
                        {{ $activeTab === $tab
                            ? 'border-brand text-heading'
                            : 'border-transparent text-body hover:text-heading' }}"
                >
                    {{ ucfirst($tab) }}
                </button>
            </li>
        @endforeach
    </ul>

    {{-- Lazy Loaded Content --}}
    <div class="mt-4">
        @if ($activeTab === 'profile')
            <livewire:organization.tabs.profile
                :organization="$organization"
                wire:key="profile-{{ $organization->id }}"
            />
        @elseif ($activeTab === 'dashboard')
            <livewire:organization.tabs.dashboard
                :organization="$organization"
                wire:key="dashboard-{{ $organization->id }}"
            />
        @elseif ($activeTab === 'settings')
            <livewire:organization.tabs.settings
                :organization="$organization"
                wire:key="settings-{{ $organization->id }}"
            />
        @elseif ($activeTab === 'invoice')
            <livewire:organization.tabs.invoice
                :organization="$organization"
                wire:key="invoice-{{ $organization->id }}"
            />
        @endif
    </div>
</div>
