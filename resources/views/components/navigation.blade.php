<nav class="flex flex-col h-auto">
    <div class="flex-1 overflow-y-auto">
        <div class="grid text-zinc-700">
            <x-nav-link :active="request()->routeIs('disnakertrans.dashboard')" href="{{ route('disnakertrans.dashboard') }}">
                <div class="group flex items-center gap-2 px-2 py-1.5 font-medium text-[1rem] font-inter rounded-md"
                    :class="{ 'justify-start': sidebarOpen, 'justify-center': !sidebarOpen }" title="Dashboard">
                    <x-heroicon-s-home class="h-5 w-5" />
                    <span x-show="sidebarOpen" x-cloak class="truncate">Dashboard</span>
                </div>
            </x-nav-link>
        </div>

        <div class="py-2">
            <ul class="space-y-1.5">
                <li class="relative">
                    <input type="checkbox" name="sidebar-accordion" id="sidebar-master" class="peer sr-only"
                        @checked(
                            request()->routeIs('disnakertrans.pekerja.*')
                            || request()->routeIs('disnakertrans.perusahaan.*')
                            || request()->routeIs('disnakertrans.agensi.*')
                            || request()->routeIs('disnakertrans.pendidikan.*')
                            || request()->routeIs('disnakertrans.perusahaan-agensi.*')
                            || request()->routeIs('disnakertrans.lowongan-pekerjaan.*')
                            || request()->routeIs('disnakertrans.agensi-lowongan.*'))>

                    <label for="sidebar-master"
                        class="group flex items-center gap-2 rounded-md px-2 py-1.5 font-inter text-[1rem] font-medium text-neutral-700 hover:bg-sky-50 hover:text-neutral-700"
                        :class="{ 'justify-start': sidebarOpen, 'justify-center': !sidebarOpen }" title="Data Master">
                        <x-heroicon-s-rectangle-stack class="h-5 w-5" />
                        <div x-show="sidebarOpen" x-cloak class="flex w-full items-center gap-2">
                            <span class="truncate">Data Master</span>
                            <x-heroicon-s-chevron-down
                                class="h-4 w-4 ml-auto transition-transform duration-200 peer-checked:rotate-180" />
                        </div>
                    </label>

                    <div x-cloak x-show="sidebarOpen"
                        class="max-h-0 overflow-hidden transition-all duration-300 peer-checked:max-h-96">
                        <ul class="mt-1 space-y-1 pl-9">
                            <li>
                                <x-nav-link :active="request()->routeIs('disnakertrans.pekerja.*')" href="{{ route('disnakertrans.pekerja.index') }}">
                                    <div class="rounded-md px-2 py-1.5 font-inter text-[1rem]">CPMI</div>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :active="request()->routeIs('disnakertrans.perusahaan.*')" href="{{ route('disnakertrans.perusahaan.index') }}">
                                    <div class="rounded-md px-2 py-1.5 font-inter text-[1rem]">P3MI</div>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :active="request()->routeIs('disnakertrans.agensi.*')" href="{{ route('disnakertrans.agensi.index') }}">
                                    <div class="rounded-md px-2 py-1.5 font-inter text-[1rem]">Agensi</div>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :active="request()->routeIs('disnakertrans.pendidikan.*')" href="{{ route('disnakertrans.pendidikan.index') }}">
                                    <div class="rounded-md px-2 py-1.5 font-inter text-[1rem]">Pendidikan</div>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :active="request()->routeIs('disnakertrans.perusahaan-agensi.*')" href="{{ route('disnakertrans.perusahaan-agensi.index') }}">
                                    <div class="rounded-md px-2 py-1.5 font-inter text-[1rem]">Kemitraan</div>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :active="request()->routeIs('disnakertrans.agensi-lowongan.*')" href="{{ route('disnakertrans.agensi-lowongan.index') }}">
                                    <div class="rounded-md px-2 py-1.5 font-inter text-[1rem]">Penempatan</div>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :active="request()->routeIs('disnakertrans.lowongan-pekerjaan.*')" href="{{ route('disnakertrans.lowongan-pekerjaan.index') }}">
                                    <div class="rounded-md px-2 py-1.5 font-inter text-[1rem]">Lowongan</div>
                                </x-nav-link>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="relative">
                    <input type="checkbox" name="sidebar-accordion" id="sidebar-report" class="peer sr-only"
                        @checked(false)>

                    <label for="sidebar-report"
                        class="group flex items-center gap-2 rounded-md px-2 py-1.5 text-[1rem] font-medium font-inter text-neutral-700 hover:bg-sky-50 hover:text-neutral-700"
                        :class="{ 'justify-start': sidebarOpen, 'justify-center': !sidebarOpen }"
                        title="Laporan & Ekspor">
                        <x-heroicon-s-chart-bar-square class="h-5 w-5" />
                        <div x-show="sidebarOpen" x-cloak class="flex w-full items-center gap-2">
                            <span class="truncate">Laporan</span>
                            <x-heroicon-s-chevron-down
                                class="h-4 w-4 ml-auto transition-transform duration-200 peer-checked:rotate-180" />
                        </div>
                    </label>

                    <div x-cloak x-show="sidebarOpen"
                        class="max-h-0 overflow-hidden transition-all duration-300 peer-checked:max-h-96">
                        <ul class="mt-1 space-y-1 pl-9">
                            <li>
                                <x-nav-link :active="false" href="#">
                                    <div class="rounded-md px-2 py-1.5 font-inter text-[1rem]">Rekap</div>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :active="false" href="#">
                                    <div class="rounded-md px-2 py-1.5 font-inter text-[1rem]">Analitik</div>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :active="false" href="#">
                                    <div class="rounded-md px-2 py-1.5 font-inter text-[1rem]">Export</div>
                                </x-nav-link>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- todo Paspor --}}
                <li class="relative">
                    <input type="checkbox" name="sidebar-accordion" id="sidebar-paspor" class="peer sr-only"
                        @checked(false)>

                    <label for="sidebar-paspor"
                        class="group flex items-center gap-2 rounded-md px-2 py-1.5 text-[1rem] font-medium font-inter text-neutral-700 hover:bg-sky-50 hover:text-neutral-700"
                        :class="{ 'justify-start': sidebarOpen, 'justify-center': !sidebarOpen }" title="Paspor">
                        <x-heroicon-s-identification class="h-5 w-5" />
                        <div x-show="sidebarOpen" x-cloak class="flex w-full items-center gap-2">
                            <span class="truncate">Pasopor</span>
                            <x-heroicon-s-chevron-down
                                class="h-4 w-4 ml-auto transition-transform duration-200 peer-checked:rotate-180" />
                        </div>
                    </label>

                    <div x-cloak x-show="sidebarOpen"
                        class="max-h-0 overflow-hidden transition-all duration-300 peer-checked:max-h-96">
                        <ul class="mt-1 space-y-1 pl-9">
                            <li>
                                <x-nav-link :active="false" href="#">
                                    <div class="rounded-md px-2 py-1.5 font-inter text-[1rem]">Paspor</div>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :active="false" href="#">
                                    <div class="rounded-md px-2 py-1.5 font-inter text-[1rem]">Surat</div>
                                </x-nav-link>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="grid gap-2 text-zinc-700">
            <x-nav-link :active="request()->routeIs('disnakertrans.dashboard')" href="{{ route('disnakertrans.dashboard') }}">
                <div class="group flex items-center gap-2 px-2 py-1.5 font-medium text-[1rem] font-inter rounded-md"
                    :class="{ 'justify-start': sidebarOpen, 'justify-center': !sidebarOpen }" title="Dashboard">
                    <x-heroicon-s-question-mark-circle class="h-5 w-5" />
                    <span x-show="sidebarOpen" x-cloak class="truncate">Bantuan</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('disnakertrans.dashboard')" href="{{ route('disnakertrans.dashboard') }}">
                <div class="group flex items-center gap-2 px-2 py-1.5 font-medium text-[1rem] font-inter rounded-md"
                    :class="{ 'justify-start': sidebarOpen, 'justify-center': !sidebarOpen }" title="Dashboard">
                    <x-heroicon-s-trash class="h-5 w-5" />
                    <span x-show="sidebarOpen" x-cloak class="truncate">Logs</span>
                </div>
            </x-nav-link>
        </div>
    </div>
</nav>
