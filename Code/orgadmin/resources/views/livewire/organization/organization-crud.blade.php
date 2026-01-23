<x-ui.crud-modal id="department-crud-modal" :show="$show" wire:click="close">
    <x-slot:title>
        Create Department
    </x-slot:title>

    <form wire:submit.prevent="save">
        <div class="grid gap-4 grid-cols-2 py-4 md:py-6">
            <div class="col-span-2">
                <label for="name" class="block mb-2.5 text-sm font-medium text-heading">Name</label>
                <input type="text" wire:model="name" name="name" id="name"
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                    placeholder="Type product name" required="" @error('name') class="border-red-500" @enderror />
            </div>
        </div>

        <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
            <button type="submit" wire:click="save"
                class="inline-flex items-center  text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                <svg class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14m-7 7V5" />
                </svg>
                Add new product
            </button>
            <button wire:click="close" type="button"
                class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Cancel</button>
        </div>
    </form>
</x-ui.crud-modal>