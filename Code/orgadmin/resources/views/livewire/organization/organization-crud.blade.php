<x-ui.crud-modal id="organization-crud-modal" :show="$show" wire:click="close">
    <x-slot:title>
        {{ $organizationId ? 'Edit Organization' : 'Create Organization' }}
    </x-slot:title>

    <form wire:submit.prevent="save">
        <div class="grid gap-4 grid-cols-2 py-4 md:py-6">
            <div class="col-span-2">
                <label for="name" class="block mb-2.5 text-sm font-medium text-heading">Organization Name</label>
                <input type="text" wire:model="name" id="name"
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                    placeholder="Type organization name" required />
                @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        @if(!$organizationId)
            <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-base text-sm text-yellow-800">
                Org Code will be auto-generated (Random 6 lowercase chars).
            </div>
        @endif

        <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
            <button type="submit" wire:target="save" wire:loading.attr="disabled"
                class="inline-flex items-center text-white bg-brand hover:bg-brand-strong disabled:opacity-60 disabled:cursor-not-allowed box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                {{-- Normal state --}}
                <svg wire:loading.remove wire:target="save" class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14m-7 7V5" />
                </svg>

                {{-- Loading spinner --}}
                <svg wire:loading wire:target="save" aria-hidden="true"
                    class="w-4 h-4 text-neutral-tertiary animate-spin fill-brand me-2" viewBox="0 0 100 101" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>

                <span wire:loading.remove wire:target="save">
                    {{ $organizationId ? 'Update Organization' : 'Create Organization' }}
                </span>

                <span wire:loading wire:target="save">
                    Saving...
                </span>
            </button>
            <button wire:click="close" type="button"
                class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Cancel</button>
        </div>
    </form>
</x-ui.crud-modal>