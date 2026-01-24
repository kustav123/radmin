<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
    {{-- Search & Filter Bar --}}
    <div class="p-4 flex items-center justify-between space-x-4">
        <label for="simple-search" class="sr-only">Search</label>
        <div class="relative flex-1 max-w-96">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" id="simple-search"
                class="block w-full ps-9 pe-3 py-2 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body"
                placeholder="Search by name or code...">
        </div>
    </div>

    {{-- Table --}}
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-t border-default-medium">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">Org Code</th>
                <th scope="col" class="px-6 py-3 font-medium">Name</th>
                <th scope="col" class="px-6 py-3 font-medium">Created By</th>
                <th scope="col" class="px-6 py-3 font-medium">Status</th>
                <th scope="col" class="px-6 py-3 font-medium">Created At</th>
                <th scope="col" class="px-6 py-3 font-medium">Actions</th>
            </tr>
        </thead>

        <tbody>
            @if($isLoading)
            <x-skeleton.table-skeleton :count="5" />
            @else
            @forelse($organizations as $org)
            <tr wire:key="org-{{ $org->id }}" class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition duration-150">
                <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-xs text-xs font-medium bg-blue-100 text-blue-800 border border-blue-400">
                        {{ $org->org_code }}
                    </span>
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    {{ $org->name }}
                </th>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-cyan-400 to-blue-500 flex items-center justify-center text-white font-bold text-xs uppercase shadow-xs">
                            {{ substr($org->creator->name ?? 'System', 0, 2) }}
                        </div>
                        <span class="ml-2 text-body">{{ $org->creator->name ?? 'System' }}</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" wire:click="toggleStatus({{ $org->id }})" class="sr-only peer" {{ $org->status ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-neutral-secondary-medium peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-soft rounded-full peer border border-default-medium peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-default-medium after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600">
                        </div>
                        <span class="ml-3 text-sm font-medium text-heading group-hover:text-fg-brand transition-colors">
                            {{ $org->status ? 'Active' : 'Inactive' }}
                        </span>
                    </label>
                </td>
                <td class="px-6 py-4 text-body text-xs">
                    {{ $org->created_at->format('M d, Y h:i A') }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-2">
                        <!-- <button wire:click="openDeptModal({{ $org->id }})"
                                class="p-2 text-purple-600 hover:bg-neutral-tertiary-medium hover:text-heading rounded-base transition-colors group relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:blocktext-xs rounded-base py-1 px-2 z-50 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-lg pointer-events-none">
                                    Manage Departments
                                </div>
                            </button> -->
                        <button wire:click="edit({{ $org->id }})"
                            class="p-2 text-fg-brand hover:bg-neutral-tertiary-medium hover:text-heading rounded-base transition-colors group relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-body">
                    <div class="flex flex-col items-center justify-center space-y-2">
                        <svg class="w-12 h-12 text-body opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="font-medium">No organizations found</p>
                        <p class="text-xs">Create one to get started!</p>
                    </div>
                </td>
            </tr>
            @endforelse
            @endif
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="p-4 border-t border-default">
        {{ $organizations->links() }}
    </div>
</div>