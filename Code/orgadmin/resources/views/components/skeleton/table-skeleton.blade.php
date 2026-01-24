<div role="status" class="animate-pulse">
    <tbody>
        @for($i = 0; $i < $count ?? 5; $i++)
            <x-skeleton.table-row-skeleton />
        @endfor
    </tbody>
    <span class="sr-only">Loading...</span>
</div>
