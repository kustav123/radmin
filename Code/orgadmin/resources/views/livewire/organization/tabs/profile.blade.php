<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    
    <!-- Card 1 -->
    <div class="card">
        <div class="bg-neutral-primary-soft block p-6 border border-default rounded-base shadow-xs">
            <h5 class="mb-3 text-2xl font-semibold tracking-tight text-heading leading-8">
                {{ $organization->name }}
            </h5>
            <p class="text-body mb-6">
                <strong>ID:</strong> {{ $organization->id }}
            </p>
            <a href="#" class="inline-flex items-center text-white bg-brand hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                Edit
            </a>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="card">
        <div class="bg-neutral-primary-soft block p-6 border border-default rounded-base shadow-xs">
            <h5 class="mb-3 text-2xl font-semibold tracking-tight text-heading leading-8">
                Others Details
            </h5>
        </div>
    </div>

    <!-- Card 3 (full width on large screens) -->
    <div class="card lg:col-span-2">
        <div class="bg-neutral-primary-soft block p-6 border border-default rounded-base shadow-xs">
            <h5 class="mb-3 text-2xl font-semibold tracking-tight text-heading leading-8">
                Modules
            </h5>
        </div>
    </div>

</div>
