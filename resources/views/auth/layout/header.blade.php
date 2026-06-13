<header class="bg-white shadow-sm">

    <div class="flex justify-between items-center px-6 py-4">

        <div>
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
                    {{ Auth::user()->name ?? 'Admin' }}
                </div>

                <div class="text-xs text-gray-500">
                    Administrator
                </div>

            </div>

        </div>

    </div>

</header>