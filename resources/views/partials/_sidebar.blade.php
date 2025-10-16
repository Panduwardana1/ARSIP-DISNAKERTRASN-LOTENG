<aside class="fixed inset-y-0 left-0 top-0 border-r bg-white ease-in-out duration-200"
    :class="{ 'w-56': sidebarOpen, 'w-16': !sidebarOpen }" aria-label="Sidebar">
    {{-- TODO Header --}}
    <div class="h-[4rem] flex items-center justify-between p-4 border-neutral-300">
        <div class="flex items-center gap-2">
            <img src="{{ asset('asset/logo.png') }}" alt="Sireda" class="h-7 w-auto duration-300"
                :class="{ 'opacity-0 scale-0 absolute': !sidebarOpen, 'opacity-100 scale-100 relative': sidebarOpen }">
            <span x-show="sidebarOpen" x-cloak class="text-xl font-semibold font-inter">Logo Here</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen"
            class="border border-neutral-300 p-1 rounded bg-neutral-200 text-neutral-600 hover:text-neutral-800 focus:outline-none"
            :aria-expanded="sidebarOpen.toString()" aria-controls="app-sidebar" title="Toggle sidebar">
            <x-heroicon-o-bars-4 class="h-5 w-5 transition-transform ease-linear"
                x-bind:class="{ 'rotate-180': !sidebarOpen }" />
        </button>
    </div>

    {{-- TODO Navigation --}}
    <nav id="app-sidebar" class="p-2">
        <x-navigation />
    </nav>

    {{-- TODO Profile Section --}}
    <div class="absolute bottom-0 left-0 right-0 bg-white p-3">
        <div class="flex items-center gap-3">
            <img src="{{ asset('icon/Sireda.png') }}" alt="Image" class="h-10 w-auto rounded-full">

            <div x-show="sidebarOpen" x-cloak class="flex flex-col">
                <span class="text-sm font-semibold font-inter text-neutral-800">
                    {{-- {{ Auth::user()->name ?? 'Guest User' }} --}}
                </span>
                <span class="text-xs font-inter text-neutral-500 truncate">
                    {{-- {{ Auth::user()->email ?? 'user@email.com' }} --}}
                </span>
            </div>

            <div x-data="{ open: false }" class="ml-auto relative" x-show="sidebarOpen" x-cloak>
                <button @click="open = !open" @keydown.escape.window="open = false"
                    class="p-1 rounded-full focus:outline-none" :aria-expanded="open.toString()" aria-haspopup="true">
                    <span class="inline-flex transition-transform duration-200" x-bind:class="{ 'rotate-180': open }">
                        <x-heroicon-o-chevron-down class="w-4 h-4 text-neutral-600" />
                    </span>
                </button>

                <div x-show="open" x-transition @click.outside="open = false"
                    class="absolute right-0 bottom-12 w-40 bg-white border rounded-lg shadow-md py-1" role="menu"
                    aria-orientation="vertical" tabindex="-1">
                    <a href="{{ route('disnakertrans.dashboard') }}"
                        class="block px-3 py-2 text-sm font-inter text-neutral-700 hover:bg-neutral-100" role="menuitem"
                        tabindex="-1">Profil</a>

                    <form method="POST" action="{{ route('disnakertrans.dashboard') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left font-inter px-3 py-2 text-sm text-rose-600 hover:bg-neutral-100"
                            role="menuitem" tabindex="-1">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>
