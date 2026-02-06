<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($modules as $module)

        @php
            $isAssigned = in_array($module->id, $assignedModules);
        @endphp

        <div
            class="relative flex flex-col justify-between rounded-lg border border-gray-200 bg-neutral-secondary-soft shadow-sm hover:shadow-md transition-all duration-200"
        >
            {{-- Assigned ribbon --}}
            @if($isAssigned)
                <span class="absolute top-3 right-3 inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-800">
                    Assigned
                </span>
            @endif

            {{-- Card body --}}
            <div class="p-6">
                <div class="flex items-start gap-4">
                    {{-- Module Icon (App / Package style) --}}
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-brand/10 text-brand">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10m0-10L4 7m8-4v14"/>
                        </svg>
                    </div>

                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-heading">
                            {{ $module->name }}
                        </h3>

                        <p class="mt-1 text-sm text-body line-clamp-2">
                            {{ $module->description ?? 'No description provided for this module.' }}
                        </p>
                    </div>
                </div>

                {{-- Meta --}}
                <div class="mt-4 flex items-center justify-between text-xs text-body">
                    <span>Version {{ $module->version }}</span>

                    @if($module->is_active)
                        <span class="inline-flex items-center rounded-md bg-blue-100 px-2 py-0.5 font-medium text-blue-800">
                            Available
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-md bg-gray-200 px-2 py-0.5 font-medium text-gray-600">
                            Disabled
                        </span>
                    @endif
                </div>
            </div>

            {{-- Card footer --}}
            <div class="border-t border-gray-200 p-4">
                @if($isAssigned)
                    <button
                        wire:click="unassignModule({{ $module->id }})"
                        class="inline-flex w-full items-center justify-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300"
                    >
                        Remove module
                    </button>
                @else
                    <button
                        wire:click="assignModule({{ $module->id }})"
                        class="inline-flex w-full items-center justify-center rounded-lg bg-brand px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-strong focus:outline-none focus:ring-4 focus:ring-brand/30"
                    >
                        Assign module
                    </button>
                @endif
            </div>
        </div>

    @endforeach
</div>
