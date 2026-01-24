<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    {{-- 🔹 Loading skeletons - REMOVE contents class --}}
    <div wire:loading.delay.longer>
        <x-skeleton.stat-card-skeleton />
    </div>
    <div wire:loading.delay.longer>
        <x-skeleton.stat-card-skeleton />
    </div>
    <div wire:loading.delay.longer>
        <x-skeleton.stat-card-skeleton />
    </div>

    {{-- 🔹 Stats Cards --}}
    <div wire:loading.remove class="contents">
        <x-stat-card title="Total Organizations" :value="$total" subtitle="Registered organizations" color="blue">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 21h18M4 21V7a1 1 0 011-1h4m10 15V7a1 1 0 00-1-1h-4m-6 0V3m0 0h6m-6 0h6" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Active" :value="$active" subtitle="Currently active" color="green">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Inactive" :value="$inactive" subtitle="Not active" color="red">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 9v6m4-6v6" />
                </svg>
            </x-slot:icon>
        </x-stat-card>
    </div>
</div>
