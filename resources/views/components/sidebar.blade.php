<aside class="flex flex-col w-full border-r max-w-[15rem] py-2 px-2 h-screen bg-white">
    <div class="flex-1 overflow-y-auto">
        <x-title-sidebar></x-title-sidebar>
        <div class="grid items-center px-2 gap-[4px]">
            <span class="font-semibold text-sm font-inter py-1.5 text-zinc-500/80">Overview</span>
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="py-[3px] px-2 rounded-md">
                    <ul class="flex items-center gap-2 font-inter font-medium">
                        <li><x-heroicon-o-home class="h-6 w-6"></x-heroicon-o-home></li>
                        <li>Dashboard</li>
                    </ul>
                </div>
            </x-nav-link>
            <span class="font-semibold text-sm font-inter py-1.5 text-zinc-500/80">Master</span>
            <x-nav-link :active="request()->routeIs('sirekap.cpmi.create')" href="{{ route('sirekap.cpmi.create') }}">
                <div class="py-[3px] px-2 rounded-md">
                    <ul class="flex items-center gap-2 font-inter font-medium">
                        <li><x-heroicon-o-identification class="h-6 w-6" />
                        <li>CPMI</li>
                    </ul>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="py-[3px] px-2 rounded-md">
                    <ul class="flex items-center gap-2 font-inter font-medium">
                        <li><x-heroicon-o-building-library class="h-6 w-6" />
                        <li>P3MI</li>
                    </ul>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="py-[3px] px-2 rounded-md">
                    <ul class="flex items-center gap-2 font-inter font-medium">
                        <li><x-heroicon-o-home class="h-6 w-6"></x-heroicon-o-home></li>
                        <li>Agensi</li>
                    </ul>
                </div>
            </x-nav-link>
            <span class="font-semibold text-sm font-inter py-1.5 text-zinc-500/80">Rekap</span>
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="py-[3px] px-2 rounded-md">
                    <ul class="flex items-center gap-2 font-inter font-medium">
                        <li><x-heroicon-o-home class="h-6 w-6"></x-heroicon-o-home></li>
                        <li>Dashboard</li>
                    </ul>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="py-[3px] px-2 rounded-md">
                    <ul class="flex items-center gap-2 font-inter font-medium">
                        <li><x-heroicon-o-home class="h-6 w-6"></x-heroicon-o-home></li>
                        <li>Dashboard</li>
                    </ul>
                </div>
            </x-nav-link>
            <span class="font-semibold text-sm font-inter py-1.5 text-zinc-500/80">Logs</span>
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="py-[3px] px-2 rounded-md">
                    <ul class="flex items-center gap-2 font-inter font-medium">
                        <li><x-heroicon-o-home class="h-6 w-6"></x-heroicon-o-home></li>
                        <li>Dashboard</li>
                    </ul>
                </div>
            </x-nav-link><x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="py-[3px] px-2 rounded-md">
                    <ul class="flex items-center gap-2 font-inter font-medium">
                        <li><x-heroicon-o-home class="h-6 w-6"></x-heroicon-o-home></li>
                        <li>Dashboard</li>
                    </ul>
                </div>
            </x-nav-link>
        </div>
    </div>
</aside>
