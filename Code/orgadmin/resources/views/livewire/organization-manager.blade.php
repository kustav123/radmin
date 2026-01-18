<div class="p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
            Organization Management
        </h2>
        <button wire:click="create()" class="px-6 py-2.5 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-full shadow-md hover:from-purple-600 hover:to-pink-600 transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
            + Create New Organization
        </button>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Organizations -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-blue-500 flex items-center justify-between transition hover:shadow-lg">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Organizations</p>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalOrgs }}</h3>
            </div>
            <div class="p-3 bg-blue-100 dark:bg-blue-900/40 rounded-full text-blue-600 dark:text-blue-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>

        <!-- Active Organizations -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-green-500 flex items-center justify-between transition hover:shadow-lg">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Active</p>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $activeOrgs }}</h3>
            </div>
            <div class="p-3 bg-green-100 dark:bg-green-900/40 rounded-full text-green-600 dark:text-green-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <!-- Inactive Organizations -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-red-500 flex items-center justify-between transition hover:shadow-lg">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Inactive</p>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $inactiveOrgs }}</h3>
            </div>
            <div class="p-3 bg-red-100 dark:bg-red-900/40 rounded-full text-red-600 dark:text-red-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
    @if (session()->has('message'))
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 transition-opacity duration-300" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Success!</span> {{ session('message') }}
            </div>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="w-full md:w-1/2">
                <form class="flex items-center">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-16 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search by name or code..." required="">
                    </div>
                </form>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Org Code</th>
                        <th scope="col" class="px-4 py-3">Name</th>
                        <th scope="col" class="px-4 py-3">Created By</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                        <th scope="col" class="px-4 py-3">Created At</th>
                        <th scope="col" class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($organizations as $org)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-150">
                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 border border-blue-400">
                                    {{ $org->org_code }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold">{{ $org->name }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-cyan-400 to-blue-500 flex items-center justify-center text-white font-bold text-xs uppercase shadow-sm">
                                        {{ substr($org->creator->name ?? 'System', 0, 2) }}
                                    </div>
                                    <span class="ml-2 text-gray-600 dark:text-gray-300">{{ $org->creator->name ?? 'System' }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <label class="relative inline-flex items-center cursor-pointer group">
                                    <input type="checkbox" wire:click="toggleStatus({{ $org->id }})" class="sr-only peer" {{ $org->status ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 group-hover:text-blue-600 transition-colors">
                                        {{ $org->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </label>
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs">
                                {{ $org->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-4 py-3">
                                <button wire:click="edit({{ $org->id }})" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-3 group relative">
                                    Edit
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-900 text-white text-xs rounded py-1 px-2 z-10 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        Edit Organization Name
                                    </div>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                No organizations found. Create one to get started!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $organizations->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity duration-300">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6 w-full max-w-md transform scale-100 transition-transform duration-300 border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $organizationId ? 'Edit Organization' : 'Create Organization' }}
                    </h3>
                    <button wire:click="closeModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form wire:submit.prevent="store">
                    <div class="mb-5">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Organization Name</label>
                        <input type="text" wire:model="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g. Acme Corp" required>
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    @if(!$organizationId)
                    <div class="mb-5 p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-xs leading-relaxed text-blue-800 dark:text-blue-300">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        Org Code will be auto-generated (Random 6 lowercase chars).
                    </div>
                    @endif

                    <div class="flex justify-end space-x-3">
                        <button type="button" wire:click="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-800">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-500/30 transition-shadow">
                            {{ $organizationId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
