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

            <div>

                <div class="font-semibold">
                    {{ Auth::guard('admin')->user()->name ?? Auth::guard('agent_luar')->user()->name ?? Auth::user()->name ?? 'Admin' }}
                </div>

                <div class="text-xs text-gray-500">
                    @php
                        $statusUser = Auth::guard('admin')->user()?->status
                            ?? Auth::guard('agent_luar')->user()?->status
                            ?? Auth::user()?->status
                            ?? 'User';
                    @endphp
                    {{ \App\Helpers\StatusHelper::formatStatus($statusUser) }}
                </div>

            </div>

        </div>

    </div>

</header>
