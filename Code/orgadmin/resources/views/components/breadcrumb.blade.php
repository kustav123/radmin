@props(['items' => []])

<!-- Breadcrumb -->
<nav class="flex mb-2.5" aria-label="Breadcrumb">
  <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
    <!-- Home Item -->
    <li class="inline-flex items-center">
      <a href="{{ $items[0]['href'] ?? '#' }}" class="inline-flex items-center text-sm font-medium text-body hover:text-fg-brand">
        <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
        </svg>
        {{ $items[0]['label'] ?? 'Home' }}
      </a>
    </li>

    <!-- Middle Items -->
    @foreach ($items as $index => $item)
      @if ($index > 0 && $index < count($items) - 1)
        <li>
          <div class="flex items-center space-x-1.5">
            <svg class="w-3.5 h-3.5 rtl:rotate-180 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
            </svg>
            <a href="{{ $item['href'] ?? '#' }}" class="inline-flex items-center text-sm font-medium text-body hover:text-fg-brand">
              {{ $item['label'] }}
            </a>
          </div>
        </li>
      @endif
    @endforeach

    <!-- Current Page (Last Item) -->
    @if (count($items) > 1)
      <li aria-current="page">
        <div class="flex items-center space-x-1.5">
          <svg class="w-3.5 h-3.5 rtl:rotate-180 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg>
          <span class="inline-flex items-center text-sm font-medium text-body-subtle">{{ $items[count($items) - 1]['label'] }}</span>
        </div>
      </li>
    @endif
  </ol>
</nav>
