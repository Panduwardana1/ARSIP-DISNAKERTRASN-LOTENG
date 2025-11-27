<aside id="sidebar-multi-level-sidebar"
    class="fixed left-0 top-0 z-40 flex h-[calc(100vh)] w-60 flex-col border-r-[1.5px] bg-white px-4 py-4 space-y-4 backdrop-blur transition-transform duration-300 lg:translate-x-0"
    aria-label="Sidebar" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:-translate-x-0'">
    <div class="flex items-center justify-between">
        <img src="{{ asset('asset/logo/Logo-Disnaker.png') }}" alt="Logo" class="h-9 w-auto">
    </div>

    <div class="absolute bottom-0 left-0 right-0 border-t-[1.5px]">
        <a href="{{ route('sirekap.user.profile.index') }}"
            class="flex items-center gap-3 200 bg-white px-3 py-3">
            @php
                $authUser = auth()->user();
                $avatarPath = $authUser?->gambar
                    ? asset('storage/' . $authUser->gambar)
                    : asset('asset/images/default-profile.jpg');
            @endphp
            <img src="{{ $avatarPath }}" alt="Profil {{ $authUser?->name ?? 'User' }}"
                class="h-10 w-10 rounded-full border border-zinc-200 object-cover"
                onerror="this.src='{{ asset('asset/images/default-profile.jpg') }}'">
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-zinc-900">{{ $authUser?->name ?? 'User' }}</p>
                <p class="truncate text-xs text-zinc-500">{{ $authUser?->email ?? '-' }}</p>
            </div>
        </a>
    </div>
    <div class="flex-1 overflow-y-auto">
        <ul class="space-y-2 font-medium">
            @can('view_dashboard')
                <li>
                    <x-nav-link :active="request()->routeIs('sirekap.dashboard.index')" href="{{ route('sirekap.dashboard.index') }}">
                        <div class="flex items-center rounded-md gap-2 transition-all duration-200">
                            <x-heroicon-o-home class="h-5 w-5 shrink-0" />
                            <span class="text-sm font-semibold">Dashboard</span>
                        </div>
                    </x-nav-link>
                </li>
            @endcan

            @can('manage_users')
                <li>
                    <x-nav-link :active="request()->routeIs('sirekap.users.*')" href="{{ route('sirekap.users.index') }}">
                        <div class="flex items-center rounded-md gap-2 transition-all duration-200">
                            <x-heroicon-o-users class="h-5 w-5 shrink-0" />
                            <span class="text-sm font-semibold">Kelola User</span>
                        </div>
                    </x-nav-link>
                </li>
            @endcan

            <li x-data>
                <button type="button"
                    class="flex items-center w-full justify-between rounded-md px-2 py-2 text-sm text-body transition hover:bg-neutral-tertiary hover:text-fg-brand"
                    @click="$store.sidebar.toggle('master')">

                    <span class="inline-flex items-center gap-2">
                        <x-heroicon-o-folder-open class="h-5 w-5 shrink-0" />
                        <span class="font-semibold">Master</span>
                    </span>

                    <span class="transition-transform duration-200"
                        x-bind:class="$store.sidebar.state.master ? 'rotate-180' : ''">
                        <x-heroicon-s-chevron-down class="w-5 h-5" />
                    </span>
                </button>

                <ul x-show="$store.sidebar.state.master" x-collapse x-cloak
                    class="space-y-2 border-l border-zinc-200 pl-4">
                    <li class="ml-4">
                        <x-nav-link :active="request()->routeIs('sirekap.tenaga-kerja.index')" href="{{ route('sirekap.tenaga-kerja.index') }}">
                            <div class="flex items-center gap-2 transition-all duration-200">
                                <span class="text-sm font-medium">CPMI</span>
                            </div>
                        </x-nav-link>
                    </li>
                    <li class="ml-4">
                        <x-nav-link :active="request()->routeIs('sirekap.perusahaan.index')" href="{{ route('sirekap.perusahaan.index') }}">
                            <div class="flex items-center gap-2 transition-all duration-200">
                                <span class="text-sm font-medium">P3MI</span>
                            </div>
                        </x-nav-link>
                    </li>
                    <li class="ml-4">
                        <x-nav-link :active="request()->routeIs('sirekap.agency.index')" href="{{ route('sirekap.agency.index') }}">
                            <div class="flex items-center gap-2 transition-all duration-200">
                                <span class="text-sm font-medium">Agency</span>
                            </div>
                        </x-nav-link>
                    </li>
                    <li class="ml-4">
                        <x-nav-link :active="request()->routeIs('sirekap.pendidikan.index')" href="{{ route('sirekap.pendidikan.index') }}">
                            <div class="flex items-center gap-2 transition-all duration-200">
                                <span class="text-sm font-medium">Pendidikan</span>
                            </div>
                        </x-nav-link>
                    </li>
                    <li class="ml-4">
                        <x-nav-link :active="request()->routeIs('sirekap.negara.index')" href="{{ route('sirekap.negara.index') }}">
                            <div class="flex items-center gap-2 transition-all duration-200">
                                <span class="text-sm font-medium">Destinasi</span>
                            </div>
                        </x-nav-link>
                    </li>
                </ul>
            </li>

            @canany(['manage_rekomendasi', 'manage_master'])
                {{-- rekomendasi --}}
                <li x-data>
                    <button @click="$store.sidebar.toggle('rekomendasi')"
                        class="flex items-center w-full justify-between rounded-md px-2 py-2 text-sm text-body transition hover:bg-neutral-tertiary hover:text-fg-brand">

                        <span class="inline-flex items-center gap-2">
                            <x-heroicon-o-document-text class="h-5 w-5" />
                            <span class="font-semibold">Kelola Rekomendasi</span>
                        </span>

                        <span class="transition-transform duration-200"
                            x-bind:class="$store.sidebar.state.rekomendasi ? 'rotate-180' : ''">
                            <x-heroicon-s-chevron-down class="w-5 h-5" />
                        </span>
                    </button>

                    <ul x-show="$store.sidebar.state.rekomendasi" x-collapse x-cloak
                        class="space-y-2 border-l border-zinc-200 pl-4">
                        @can('manage_rekomendasi')
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.author.index')" href="{{ route('sirekap.author.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Author</span>
                                    </div>
                                </x-nav-link>
                            </li>
                        @endcan
                        @canany(['manage_rekomendasi', 'manage_master'])
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.rekomendasi.data')" href="{{ route('sirekap.rekomendasi.data') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Rekom</span>
                                    </div>
                                </x-nav-link>
                            </li>
                        @endcanany
                    </ul>
                </li>
            @endcanany

            <li x-data>
                <button @click="$store.sidebar.toggle('wilayah')"
                    class="flex items-center w-full justify-between rounded-md px-2 py-2 text-sm text-body transition hover:bg-neutral-tertiary hover:text-fg-brand">

                    <span class="inline-flex items-center gap-2">
                        <x-heroicon-o-map class="h-5 w-5" />
                        <span class="font-semibold">Kelola Wilayah</span>
                    </span>

                    <span class="transition-transform duration-200"
                        x-bind:class="$store.sidebar.state.wilayah ? 'rotate-180' : ''">
                        <x-heroicon-s-chevron-down class="w-5 h-5" />
                    </span>
                </button>

                <ul x-show="$store.sidebar.state.wilayah" x-collapse x-cloak
                    class="space-y-2 border-l border-zinc-200 pl-4">
                    <li class="ml-4">
                        <x-nav-link :active="request()->routeIs('sirekap.kecamatan.index')" href="{{ route('sirekap.kecamatan.index') }}">
                            <div class="flex items-center gap-2 transition-all duration-200">
                                <span class="text-sm font-medium">Kecamatan</span>
                            </div>
                        </x-nav-link>
                    </li>
                    <li class="ml-4">
                        <x-nav-link :active="request()->routeIs('sirekap.desa.index')" href="{{ route('sirekap.desa.index') }}">
                            <div class="flex items-center gap-2 transition-all duration-200">
                                <span class="text-sm font-medium">Desa</span>
                            </div>
                        </x-nav-link>
                    </li>
                </ul>
            </li>

            {{-- ! logs --}}
            @can('view_activity_log')
                <li>
                    <x-nav-link :active="request()->routeIs('sirekap.logs.index')" href="{{ route('sirekap.logs.index') }}">
                        <div class="flex items-center rounded-md gap-2 transition-all duration-200">
                            <x-heroicon-o-clipboard-document-list class="h-5 w-5 shrink-0" />
                            <span class="text-sm font-semibold">Log Aktivitas</span>
                        </div>
                    </x-nav-link>
                </li>
            @endcan
        </ul>
    </div>
</aside>
