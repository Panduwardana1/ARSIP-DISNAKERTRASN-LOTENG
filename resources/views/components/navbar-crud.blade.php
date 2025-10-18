<div class="flex flex-col gap-3 p-3 sm:flex-row sm:items-center sm:justify-between">
    <x-search-data class="w-full sm:max-w-md" placeholder="Cari nama atau NIK" :action="route('sirekap.cpmi.index')"
        name="keyword" />

    <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:items-center sm:justify-end">
        {{ $slot }}
    </div>
</div>
