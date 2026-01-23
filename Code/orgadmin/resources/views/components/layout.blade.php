@props(['breadcrumbs' => [], 'header' => null])

<x-app-layout>
    <!-- Breadcrumb -->
    @if (!empty($breadcrumbs))
        <x-breadcrumb :items="$breadcrumbs" />
    @endif

    @if (isset($header))
        {{ $header }}
    @endif


    <!-- Main Content -->
    <!-- <main class="flex-grow"> -->
        {{ $slot }}
    <!-- </main> -->

</x-app-layout>