@props(['label' => 'Options'])

<div x-data="{ open: false }" class="relative inline-block text-left">
    <button @click="open = !open" @click.away="open = false"
        class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white bg-black ring-1 ring-inset ring-white/5 hover:bg-black/60 focus:outline-none">
        {{ $label }}
        <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="-mr-1 h-5 w-5 text-gray-400">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" />
        </svg>
    </button>

    <div x-show="open" x-transition.opacity.scale.90
        class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-gray-800 shadow-lg ring-1 ring-white/10 focus:outline-none">
        <div class="py-1">
            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white">Account
                settings</a>
            <a href="#"
                class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white">Support</a>
            <a href="#"
                class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white">License</a>
            <form method="POST" action="#">
                <button type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white">
                    Sign out
                </button>
            </form>
        </div>
    </div>
</div>
