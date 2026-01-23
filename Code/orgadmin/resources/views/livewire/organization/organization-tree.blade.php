<div id="accordion-card" data-accordion="collapse">

    @if(count($tree) > 0)

        @foreach($tree as $index => $org)

            {{-- Accordion Header --}}
            <h2 id="accordion-heading-{{ $index }}" class="{{ $index > 0 ? 'mt-4' : '' }}">
                <button type="button" class="flex items-center justify-between w-full p-5 font-medium
                                           rtl:text-right text-body rounded-base shadow-xs
                                           border border-default hover:text-heading
                                           hover:bg-neutral-secondary-medium gap-3
                                           [&[aria-expanded='true']]:rounded-b-none
                                           [&[aria-expanded='true']]:shadow-none"
                    data-accordion-target="#accordion-body-{{ $index }}" aria-expanded="false"
                    aria-controls="accordion-body-{{ $index }}">
                    <div class="flex items-center gap-3 text-left">
                        <span
                            class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded
                                                     dark:bg-blue-900 dark:text-blue-200 border border-blue-200 dark:border-blue-800">
                            {{ $org->org_code }}
                        </span>

                        <span class="text-base font-semibold text-heading">
                            {{ $org->name }}
                        </span>

                        <span
                            class="text-xs {{ $org->status ? 'text-green-600 dark:text-green-400' : 'text-red-500 dark:text-red-400' }}">
                            ● {{ $org->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <svg data-accordion-icon class="w-5 h-5 rotate-180 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 15 7-7 7 7" />
                    </svg>
                </button>
            </h2>

            {{-- Accordion Body --}}
            <div id="accordion-body-{{ $index }}" class="hidden border border-t-0 border-default rounded-b-base shadow-xs"
                aria-labelledby="accordion-heading-{{ $index }}">
                <div class="p-4 md:p-5 text-sm text-gray-600 dark:text-gray-300">

                    @if(!empty($org->department))
                        <div class="font-semibold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-3">
                            Departments
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                            @foreach($org->department as $dept)

                                <div class="bg-neutral-primary-soft border border-default rounded-base shadow-xs
                                                    hover:shadow-sm transition-shadow">

                                    <div class="p-5 text-center">

                                        {{-- Status Badge --}}
                                        <span class="inline-flex items-center text-xs font-medium px-1.5 py-0.5 rounded-sm
                                                    {{ ($dept['status'] ?? true)
                                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                                    : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300' }}">
                                            {{ ($dept['status'] ?? true) ? 'Active' : 'Inactive' }}
                                        </span>

                                        {{-- Department Name --}}
                                        <h5 class="mt-4 mb-5 text-xl font-semibold tracking-tight text-heading">
                                            {{ $dept['name'] }}
                                        </h5>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                    @else
                        <span class="italic text-gray-400">
                            No departments found.
                        </span>
                    @endif

                </div>
            </div>

        @endforeach

    @else
        <div class="text-center py-10 text-gray-500 dark:text-gray-400">
            No data available using Tree View.
        </div>
    @endif

</div>