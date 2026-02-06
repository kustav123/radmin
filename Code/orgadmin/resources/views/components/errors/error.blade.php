<x-layouts.error :title="$title ?? 'Oops!'">
    <div class="text-center animate-fadeIn space-y-6 px-6">
        
        {{-- Illustration (Flowbite Customized) --}}
        <img 
            src="{{ asset('images/errors/404.svg') }}"
            alt="Error"
            class="mx-auto w-64 dark:opacity-80"
        />

        <h1 class="text-4xl font-bold">{{ $code ?? 'Error' }}</h1>

        <p class="text-lg text-gray-600 dark:text-gray-300">
            {{ $message ?? 'Something went wrong. Please try again later.' }}
        </p>

        <a href="{{ url('/') }}"
           class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-all duration-300 
                  animate-pulse dark:bg-indigo-500 dark:hover:bg-indigo-600">
            Go Home
        </a>

    </div>
</x-layouts.error>
