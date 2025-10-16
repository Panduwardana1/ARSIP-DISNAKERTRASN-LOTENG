@props([
    'title' => null,
    'subtitle' => null,
])

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<div class="min-h-screen" x-data="layoutShell()" x-init="init()">
    {{-- Mobile overlay --}}
    <div x-show="open && !isDesktop" x-transition.opacity class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"
        @click="closeSidebar()" x-cloak></div>

    {{-- Sidebar --}}
    <aside x-cloak
        class="fixed inset-y-0 left-0 z-40 flex h-full flex-col border-r border-slate-200 bg-white/95 backdrop-blur transition-all duration-300 ease-in-out lg:translate-x-0"
        :class="{
            'translate-x-0 w-72': open || isDesktop,
            '-translate-x-full w-72': !open && !isDesktop,
            'lg:w-72': isDesktop && !collapsed,
            'lg:w-20': isDesktop && collapsed
        }">
        <div class="flex h-16 items-center gap-3 border-b border-slate-200 px-4">
            <button @click="toggleSidebar()" type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-400/40"
                :aria-expanded="(!collapsed || !isDesktop).toString()" aria-controls="app-sidebar">
                <x-heroicon-o-chevron-double-left class="h-5 w-5" x-show="isDesktop" />
                <x-heroicon-o-x-mark class="h-5 w-5" x-show="!isDesktop && open" x-cloak />
                <x-heroicon-o-bars-3 class="h-5 w-5" x-show="!isDesktop && !open" x-cloak />
            </button>

            <div class="flex-1 truncate" x-show="!collapsed || !isDesktop" x-transition x-cloak>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Sirekap</p>
                <p class="text-base font-semibold text-slate-800">Disnakertrans Hub</p>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto">
            <div class="space-y-6 py-4" x-show="!collapsed || !isDesktop" x-transition.opacity x-cloak>
                <div class="px-4">
                    <label class="relative block">
                        <x-heroicon-o-magnifying-glass class="pointer-events-none absolute left-3 top-2.5 h-4 w-4 text-slate-400" />
                        <input type="search" placeholder="Cari menu..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2 pl-9 pr-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100">
                    </label>
                </div>

        <nav id="app-sidebar" class="flex flex-col gap-6 px-2">
            <x-navigation />
        </nav>
            </div>

            {{-- Collapsed icon rail --}}
            <div class="flex flex-col items-center gap-3 py-6" x-show="collapsed && isDesktop" x-cloak>
                <x-nav-link
                    href="{{ \Illuminate\Support\Facades\Route::has('disnakertrans.dashboard') ? route('disnakertrans.dashboard') : '#' }}"
                    :active="request()->routeIs('disnakertrans.dashboard')">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600">
                        <x-heroicon-s-home class="h-5 w-5" />
                    </span>
                </x-nav-link>
                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600"
                    @click="collapsed = false" title="Perluas menu">
                    <x-heroicon-o-arrow-right class="h-5 w-5" />
                </button>
            </div>
        </div>

        <div class="border-t border-slate-200 p-4">
            <div class="flex items-center gap-3 rounded-2xl bg-slate-50 p-3" x-show="!collapsed || !isDesktop" x-cloak>
                <img src="{{ asset('asset/logo.png') }}" alt="User thumbnail" class="h-10 w-10 rounded-full object-cover" />
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-slate-800">
                        {{ Auth::user()->name ?? 'Guest User' }}
                    </p>
                    <p class="truncate text-xs text-slate-500">
                        {{ Auth::user()->email ?? 'user@email.com' }}
                    </p>
                </div>
                <div x-data="{ open: false }" class="relative ml-auto">
                    <button @click="open = !open" @keydown.escape.window="open = false" type="button"
                        class="rounded-full bg-white p-2 text-slate-500 shadow-sm transition hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-300">
                        <x-heroicon-o-ellipsis-vertical class="h-4 w-4" />
                    </button>
                    <div x-show="open" x-transition @click.outside="open = false"
                        class="absolute right-0 top-full mt-2 w-40 rounded-xl border border-slate-200 bg-white py-1.5 text-sm shadow-xl">
                        <a href="{{ \Illuminate\Support\Facades\Route::has('profile.show') ? route('profile.show') : '#' }}"
                            class="block px-3 py-2 text-slate-600 hover:bg-slate-50 hover:text-slate-900">Profil</a>
                        @if (\Illuminate\Support\Facades\Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex w-full items-center gap-2 px-3 py-2 text-left text-rose-600 hover:bg-rose-50">
                                    <x-heroicon-o-arrow-left-on-rectangle class="h-4 w-4" />
                                    Logout
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex justify-center" x-show="collapsed && isDesktop" x-cloak>
                <button type="button" @click="collapsed = false"
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-300"
                    title="Buka panel profil">
                    <x-heroicon-o-user class="h-5 w-5" />
                </button>
            </div>
        </div>
    </aside>

    {{-- Content --}}
    <div class="relative flex min-h-screen flex-col transition-[padding] duration-300 ease-in-out"
        :class="{
            'lg:pl-72': isDesktop && !collapsed,
            'lg:pl-20': isDesktop && collapsed
        }">
        <header
            class="sticky top-0 z-10 flex h-16 items-center border-b border-slate-200 bg-white/80 px-4 backdrop-blur supports-[backdrop-filter]:bg-white/70">
            <div class="flex flex-1 items-center gap-3">
                <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-400/40 lg:hidden"
                    @click="open = !open">
                    <x-heroicon-o-bars-3 class="h-5 w-5" />
                </button>

                <div class="min-w-0">
                    @if ($title)
                        <h1 class="truncate text-lg font-semibold text-slate-900">{{ $title }}</h1>
                    @endif

                    @if ($subtitle)
                        <p class="truncate text-sm text-slate-500">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>

            @isset($headerActions)
                <div class="flex items-center gap-2">
                    {{ $headerActions }}
                </div>
            @endisset
        </header>

        @isset($headerLeft)
            <div class="border-b border-slate-200 bg-white px-4 py-3">
                {{ $headerLeft }}
            </div>
        @endisset

        <main class="flex-1 bg-slate-100 p-4 lg:p-8">
            {{ $slot }}
        </main>
    </div>
</div>

@once
    @push('scripts')
        <script>
            function layoutShell() {
                return {
                    isDesktop: false,
                    open: false,
                    collapsed: false,
                    init() {
                        const mq = window.matchMedia('(min-width: 1024px)');
                        const update = (event) => {
                            const matches = event.matches ?? event.currentTarget.matches;
                            this.isDesktop = matches;
                            this.open = matches;
                            if (!matches) {
                                this.collapsed = false;
                            }
                        };

                        update(mq);
                        if (mq.addEventListener) {
                            mq.addEventListener('change', update);
                        } else {
                            mq.addListener(update);
                        }
                    },
                    toggleSidebar() {
                        if (this.isDesktop) {
                            this.collapsed = !this.collapsed;
                        } else {
                            this.open = !this.open;
                        }
                    },
                    closeSidebar() {
                        if (!this.isDesktop) {
                            this.open = false;
                        }
                    },
                };
            }
        </script>
    @endpush
@endonce
