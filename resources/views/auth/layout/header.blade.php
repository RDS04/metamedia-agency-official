<header class="bg-white shadow-sm">

    <div class="flex justify-between items-center px-6 py-4">

        <div class="flex items-center gap-4">
            <!-- Hamburger Button (Mobile Only) -->
            <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 focus:outline-none md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <h1 class="text-xl font-bold text-gray-700">
                @yield('page-title')
            </h1>
        </div>

        <div class="flex items-center gap-3">

            <img
                src="https://i.pravatar.cc/40"
                class="w-10 h-10 rounded-full">

            <div>

                <div class="font-semibold">
                    {{ Auth::guard('admin')->user()->name ?? Auth::user()->name ?? 'Admin' }}
                </div>

                <div class="text-xs text-gray-500">
                    {{ \App\Helpers\StatusHelper::formatStatus(Auth::user()->status ?? 'User') }}
                </div>

            </div>

        </div>

    </div>

</header>
