<div class="grid w-full min-w-full border rounded-md h-20 font-inter">
    <span class="pb-8">
        <h2 class="text-3xl">@yield('titlePageContent', 'Title')</h2>
        <p class="text-sm">@yield('description', '')</p>
    </span>
    <div class="flex items-center justify-between gap-2">
        <div class="flex items-center gap-2">
            @yield('search')
        </div>
        <div class="flex items-center gap-2">
            @yield('buttonAction', '')
            {{ $slot }}
        </div>
    </div>
</div>
