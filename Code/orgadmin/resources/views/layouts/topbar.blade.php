<nav class="fixed top-0 z-50 w-full bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 transition-colors duration-200">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start rtl:justify-end">
        <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar" aria-controls="top-bar-sidebar" type="button" class="sm:hidden text-gray-700 dark:text-gray-300 bg-transparent box-border border border-transparent hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-600 font-medium leading-5 rounded-base text-sm p-2 focus:outline-none transition-colors duration-200">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
            </svg>
         </button>
        <a href="{{ route('dashboard') }}" class="flex ms-2 md:me-24">
          <span class="self-center text-lg font-semibold whitespace-nowrap text-gray-900 dark:text-white transition-colors duration-200">{{ config('app.name', 'App') }}</span>
        </a>
      </div>
      <div class="flex items-center gap-3">
          <!-- Dark Mode Toggle -->
          <button id="theme-toggle" type="button" onclick="window.toggleTheme()" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 transition-colors duration-200" title="Toggle Dark Mode">
            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
          </button>

          <div class="flex items-center ms-3">
            <div>
              <button type="button" class="flex text-sm bg-gray-800 dark:bg-gray-700 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 transition-all duration-200 overflow-hidden" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full object-cover" src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=0D8ABC&color=fff' }}" alt="{{ auth()->user()->name ?? 'User' }}">
              </button>
            </div>
            <div class="z-50 hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg w-44 transition-colors duration-200" id="dropdown-user">
              <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700" role="none">
                <p class="text-sm font-medium text-gray-900 dark:text-white" role="none">
                  {{ auth()->user()->name ?? 'User' }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400 truncate" role="none">
                  {{ auth()->user()->email ?? 'user@example.com' }}
                </p>
              </div>
              <ul class="p-2 text-sm text-gray-700 dark:text-gray-300 font-medium" role="none">
                <li>
                  <a href="{{ route('profile.show') }}" class="inline-flex items-center w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-white rounded transition-colors duration-200" role="menuitem">Profile</a>
                </li>
                <li>
                  <a href="#" class="inline-flex items-center w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-white rounded transition-colors duration-200" role="menuitem">Settings</a>
                </li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-white rounded transition-colors duration-200" role="menuitem">Sign out</button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
    </div>
  </div>
</nav>