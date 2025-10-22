@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Dashboard Admin')
{{-- @section('titleContent', 'Dashboard Overview') --}}

@section('content')
    <div class="space-y-4 font-inter p-4">
        <header class="relative overflow-hidden px-4 py-4">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div class="space-y-0">
                    <span class="items-center rounded-full text-zinc-800 text-lg font-semibold tracking-wide">Dashboard Admin Overview</span>
                    <h1 class="text-3xl font-semibold leading-tight">Ringkasan Aktivitas Sistem</h1>
                </div>
                <div class="flex items-center gap-2">
                    <p class="text-lg">{{ now()->format('l, d F Y') }}</p>
                    <x-heroicon-s-calendar-days class="h-8 w-8 text-zinc-800" />
                </div>
            </div>
            <div class="pointer-events-none absolute -right-16 bottom-0 hidden h-40 w-40 rounded-full border border-white/40 bg-white/10 blur-xl md:block"></div>
        </header>

        <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach (range(1, 3) as $index)
                <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div class="space-y-3">
                            <div class="h-3 w-24 rounded bg-slate-200"></div>
                            <div class="h-7 w-32 rounded bg-slate-100"></div>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-sky-100 text-sky-600">
                            <x-heroicon-s-chart-bar class="h-6 w-6" />
                        </span>
                    </div>
                    <div class="mt-6 space-y-2">
                        <div class="h-2 w-full rounded bg-slate-100"></div>
                        <div class="h-2 w-3/4 rounded bg-slate-100"></div>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="grid grid-cols-1 gap-4 lg:grid-cols-5">
            <div class="col-span-1 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-3">
                <header class="flex items-center justify-between">
                    <div class="space-y-2">
                        <div class="h-3 w-32 rounded bg-slate-200"></div>
                        <div class="h-3 w-48 rounded bg-slate-100"></div>
                    </div>
                    <span class="h-8 w-20 rounded-full bg-slate-100"></span>
                </header>
                <div class="mt-6 grid h-64 place-items-center rounded-xl border border-dashed border-slate-200 bg-slate-50">
                    <div class="space-y-3 text-center">
                        <span class="mx-auto block h-10 w-10 rounded-full bg-slate-200"></span>
                        <p class="text-sm font-medium text-slate-500">Area visualisasi chart</p>
                        <p class="text-xs text-slate-400">Letakkan grafik tren atau performa di sini.</p>
                    </div>
                </div>
            </div>
            <div class="space-y-4 lg:col-span-2">
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="space-y-3">
                        <div class="h-3 w-24 rounded bg-slate-200"></div>
                        <div class="space-y-2">
                            <div class="h-2 w-full rounded bg-slate-100"></div>
                            <div class="h-2 w-3/4 rounded bg-slate-100"></div>
                            <div class="h-2 w-2/3 rounded bg-slate-100"></div>
                        </div>
                    </div>
                    <div class="mt-6 grid gap-3">
                        @foreach (range(1, 3) as $item)
                            <div class="flex items-center justify-between rounded-lg border border-slate-200 p-3">
                                <div class="space-y-2">
                                    <div class="h-2 w-36 rounded bg-slate-100"></div>
                                    <div class="h-2 w-24 rounded bg-slate-100"></div>
                                </div>
                                <span class="h-8 w-20 rounded-full bg-slate-100"></span>
                            </div>
                        @endforeach
                    </div>
                </article>
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="space-y-3">
                        <div class="h-3 w-20 rounded bg-slate-200"></div>
                        <div class="h-3 w-40 rounded bg-slate-100"></div>
                    </div>
                    <div class="mt-6 h-32 rounded-xl border border-dashed border-slate-200 bg-slate-50"></div>
                </article>
            </div>
        </section>

        <section class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <header class="flex flex-wrap items-center justify-between gap-4">
                <div class="space-y-2">
                    <div class="h-3 w-28 rounded bg-slate-200"></div>
                    <div class="h-3 w-52 rounded bg-slate-100"></div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="h-9 w-28 rounded-full bg-slate-100"></span>
                    <span class="h-9 w-24 rounded-full bg-slate-100"></span>
                </div>
            </header>
            <div class="overflow-hidden rounded-xl border border-slate-200">
                <table class="w-full border-collapse">
                    <thead class="bg-slate-50">
                        <tr class="divide-x divide-slate-200 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            @foreach (['Kolom', 'Deskripsi', 'Status', 'Aksi'] as $column)
                                <th class="px-6 py-4">
                                    <div class="h-2 w-16 rounded bg-slate-200"></div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach (range(1, 5) as $row)
                            <tr class="divide-x divide-slate-200">
                                <td class="px-6 py-5"><div class="h-3 w-24 rounded bg-slate-100"></div></td>
                                <td class="px-6 py-5">
                                    <div class="space-y-2">
                                        <div class="h-2 w-32 rounded bg-slate-100"></div>
                                        <div class="h-2 w-20 rounded bg-slate-100"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-5"><div class="h-2 w-16 rounded-full bg-slate-100"></div></td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <span class="h-8 w-16 rounded bg-slate-100"></span>
                                        <span class="h-8 w-16 rounded bg-slate-100"></span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
