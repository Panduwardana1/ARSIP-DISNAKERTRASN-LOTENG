@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Dashboard Admin')
@section('titleContent', 'Dashboard Admin')

@section('content')
    @php
        $metrics = $metrics ?? [];
        $statCards = [
            [
                'title' => 'Total CPMI',
                'value' => number_format($metrics['cpmi_total'] ?? 0),
                'delta' => $metrics['cpmi_delta'] ?? null,
                'icon' => 'heroicon-o-identification',
                'accent' => 'bg-emerald-500',
            ],
            [
                'title' => 'Total P3MI',
                'value' => number_format($metrics['perusahaan_total'] ?? 0),
                'delta' => $metrics['perusahaan_delta'] ?? null,
                'icon' => 'heroicon-o-building-library',
                'accent' => 'bg-sky-500',
            ],
            [
                'title' => 'Lowongan Aktif',
                'value' => number_format($metrics['lowongan_aktif'] ?? 0),
                'delta' => $metrics['lowongan_delta'] ?? null,
                'icon' => 'heroicon-o-briefcase',
                'accent' => 'bg-amber-500',
            ],
            [
                'title' => 'Pengaduan Terbuka',
                'value' => number_format($metrics['pengaduan_terbuka'] ?? 0),
                'delta' => $metrics['pengaduan_delta'] ?? null,
                'icon' => 'heroicon-o-chat-bubble-left-right',
                'accent' => 'bg-rose-500',
            ],
        ];

        $pendingVerifications = collect($pendingVerifications ?? [])->take(5);
        $recentTenagaKerja = collect($recentTenagaKerja ?? [])->take(5);
        $recentLowongan = collect($recentLowongan ?? [])->take(5);
        $activities = collect($activities ?? [])->take(6);
        $userName = trim((string) ($currentUser['name'] ?? ($currentUser?->name ?? 'Admin')));
        $tipOfTheDay = $tipOfTheDay ?? 'Pantau terus status arsip CPMI untuk memastikan kelengkapan dokumen.';
    @endphp

    <div class="flex flex-col gap-6 bg-slate-100/60 px-4 py-6 md:px-6 lg:px-8">
        <header class="flex flex-col justify-between gap-4 rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm sm:flex-row sm:items-center">
            <div>
                <p class="text-sm font-medium text-zinc-500">Selamat datang kembali,</p>
                <h2 class="text-2xl font-semibold text-zinc-800">{{ $userName }}</h2>
                <p class="mt-1 text-sm text-zinc-500">Kelola arsip CPMI, P3MI, dan lowongan secara terpadu.</p>
            </div>
            <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
                <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-2 text-sm text-emerald-700">
                    {{ $tipOfTheDay }}
                </div>
                <a href="{{ route('sirekap.tenaga-kerja.create') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600">
                    <x-heroicon-o-plus class="mr-2 h-4 w-4" />
                    Tambah CPMI
                </a>
            </div>
        </header>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($statCards as $card)
                <article class="rounded-2xl border border-zinc-200 bg-white/90 p-5 shadow-sm backdrop-blur-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-zinc-500">{{ $card['title'] }}</p>
                            <p class="mt-2 text-2xl font-semibold text-zinc-800">{{ $card['value'] }}</p>
                        </div>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl {{ $card['accent'] }}">
                            <x-dynamic-component :component="$card['icon']" class="h-5 w-5 text-white" />
                        </span>
                    </div>
                    @if (!is_null($card['delta']))
                        <div class="mt-4 inline-flex items-center gap-1 rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-600">
                            <x-heroicon-o-arrow-trending-up class="h-3.5 w-3.5" />
                            {{ $card['delta'] }}
                        </div>
                    @endif
                </article>
            @endforeach
        </section>

        <section class="grid gap-6 xl:grid-cols-3">
            <div class="space-y-6 rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm xl:col-span-2">
                <header class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-zinc-800">Rekap Aktivitas Bulanan</h3>
                        <p class="text-sm text-zinc-500">Perbandingan data CPMI, P3MI, dan lowongan setiap bulan.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <select class="rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-600 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20">
                            <option value="12">12 Bulan</option>
                            <option value="6">6 Bulan</option>
                            <option value="3">3 Bulan</option>
                        </select>
                        <button class="inline-flex items-center gap-1 rounded-lg border border-zinc-200 px-3 py-2 text-sm font-medium text-zinc-600 transition hover:border-zinc-300 hover:text-zinc-800">
                            <x-heroicon-o-arrow-path class="h-4 w-4" />
                            Segarkan
                        </button>
                    </div>
                </header>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-xl border border-zinc-100 bg-zinc-50/50 p-4">
                        <p class="text-sm font-medium text-zinc-600">Total CPMI per Bulan</p>
                        <div class="mt-3 flex items-end gap-2">
                            @foreach (range(1, 6) as $index)
                                <span class="flex-1 rounded-md bg-emerald-500/70" style="height: {{ 20 + $index * 6 }}px"></span>
                            @endforeach
                        </div>
                        <p class="mt-4 text-xs text-zinc-400">Data diambil dari arsip masuk 6 bulan terakhir.</p>
                    </div>
                    <div class="rounded-xl border border-zinc-100 bg-zinc-50/50 p-4">
                        <p class="text-sm font-medium text-zinc-600">Sebaran Lowongan Aktif</p>
                        <ul class="mt-3 space-y-2 text-sm text-zinc-600">
                            <li class="flex items-center justify-between">
                                <span>Asia Timur</span>
                                <span class="font-semibold text-zinc-800">{{ $metrics['lowongan_asia_timur'] ?? 0 }}</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <span>Timur Tengah</span>
                                <span class="font-semibold text-zinc-800">{{ $metrics['lowongan_timur_tengah'] ?? 0 }}</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <span>Eropa</span>
                                <span class="font-semibold text-zinc-800">{{ $metrics['lowongan_eropa'] ?? 0 }}</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <span>Domestik</span>
                                <span class="font-semibold text-zinc-800">{{ $metrics['lowongan_domestik'] ?? 0 }}</span>
                            </li>
                        </ul>
                        <p class="mt-4 text-xs text-zinc-400">Periksa data destinasi pada menu lowongan untuk detail lebih lanjut.</p>
                    </div>
                </div>
            </div>

            <aside class="flex flex-col gap-4 rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <header>
                    <h3 class="text-lg font-semibold text-zinc-800">Tugas Verifikasi</h3>
                    <p class="text-sm text-zinc-500">Daftar dokumen CPMI yang perlu tindak lanjut segera.</p>
                </header>
                <ul class="flex flex-col gap-3 text-sm text-zinc-600">
                    @forelse ($pendingVerifications as $item)
                        <li class="rounded-xl border border-zinc-100 bg-zinc-50/60 px-3 py-3">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-zinc-800">{{ $item['nama'] ?? $item->nama ?? 'CPMI' }}</span>
                                <span class="text-xs text-amber-600">
                                    {{ $item['status'] ?? $item->status ?? 'Menunggu' }}
                                </span>
                            </div>
                            <p class="mt-1 text-xs text-zinc-500">
                                {{ $item['lowongan'] ?? $item->lowongan->nama ?? 'Lowongan belum dipilih' }}
                            </p>
                            <p class="mt-2 text-xs text-zinc-400">
                                Diperbarui: {{ $item['updated_at'] ?? optional($item->updated_at)->format('d M Y') ?? '-' }}
                            </p>
                        </li>
                    @empty
                        <li class="rounded-xl border border-dashed border-zinc-200 px-3 py-4 text-center text-xs text-zinc-400">
                            Tidak ada tugas verifikasi yang tertunda.
                        </li>
                    @endforelse
                </ul>
                <a href="{{ route('sirekap.tenaga-kerja.index') }}" class="inline-flex items-center justify-center rounded-xl border border-amber-200 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 hover:border-amber-300 hover:text-amber-800">
                    Lihat Semua CPMI
                </a>
            </aside>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <article class="rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <header class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-zinc-800">CPMI Terbaru</h3>
                        <p class="text-sm text-zinc-500">Pendaftaran yang baru masuk ke sistem.</p>
                    </div>
                    <a href="{{ route('sirekap.tenaga-kerja.index') }}" class="text-sm font-semibold text-amber-600 hover:text-amber-700">Lihat semua</a>
                </header>
                <ul class="mt-5 space-y-3">
                    @forelse ($recentTenagaKerja as $tenaga)
                        <li class="flex items-start justify-between rounded-xl border border-zinc-100 bg-zinc-50/60 px-4 py-3">
                            <div>
                                <p class="font-semibold text-zinc-800">{{ $tenaga['nama'] ?? $tenaga->nama ?? 'Nama tidak tersedia' }}</p>
                                <p class="text-xs text-zinc-500">NIK:
                                    {{ $tenaga['nik'] ?? $tenaga->nik ?? '-' }}
                                </p>
                                <p class="mt-1 text-xs text-zinc-400">
                                    Lowongan: {{ $tenaga['lowongan'] ?? optional($tenaga->lowongan)->nama ?? '-' }}
                                </p>
                            </div>
                            <span class="text-xs text-zinc-400">
                                {{ $tenaga['tanggal'] ?? optional($tenaga->created_at)->format('d M Y') ?? '-' }}
                            </span>
                        </li>
                    @empty
                        <li class="rounded-xl border border-dashed border-zinc-200 px-4 py-5 text-center text-xs text-zinc-400">
                            Belum ada data CPMI terbaru.
                        </li>
                    @endforelse
                </ul>
            </article>

            <article class="rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <header class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-zinc-800">Lowongan Terbaru</h3>
                        <p class="text-sm text-zinc-500">Perubahan terbaru pada data lowongan.</p>
                    </div>
                    <a href="{{ route('sirekap.lowongan.index') }}" class="text-sm font-semibold text-amber-600 hover:text-amber-700">Lihat semua</a>
                </header>
                <ul class="mt-5 space-y-3">
                    @forelse ($recentLowongan as $lowongan)
                        <li class="flex items-start justify-between rounded-xl border border-zinc-100 bg-zinc-50/60 px-4 py-3">
                            <div>
                                <p class="font-semibold text-zinc-800">{{ $lowongan['nama'] ?? $lowongan->nama ?? 'Lowongan' }}</p>
                                <p class="text-xs text-zinc-500">
                                    {{ $lowongan['perusahaan'] ?? optional($lowongan->perusahaan)->nama ?? 'P3MI belum diatur' }}
                                </p>
                                <p class="mt-1 text-xs text-zinc-400">
                                    Agensi: {{ $lowongan['agensi'] ?? optional($lowongan->agensi)->nama ?? '-' }}
                                </p>
                            </div>
                            <span class="text-xs text-zinc-400">
                                {{ $lowongan['tanggal'] ?? optional($lowongan->updated_at)->format('d M Y') ?? '-' }}
                            </span>
                        </li>
                    @empty
                        <li class="rounded-xl border border-dashed border-zinc-200 px-4 py-5 text-center text-xs text-zinc-400">
                            Belum ada lowongan terbaru yang tersimpan.
                        </li>
                    @endforelse
                </ul>
            </article>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <article class="rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm lg:col-span-2">
                <header class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-zinc-800">Aktivitas Terakhir</h3>
                        <p class="text-sm text-zinc-500">Log aktivitas sistem selama 24 jam terakhir.</p>
                    </div>
                    <button class="inline-flex items-center gap-1 rounded-lg border border-zinc-200 px-3 py-2 text-sm font-medium text-zinc-600 transition hover:border-zinc-300 hover:text-zinc-800">
                        <x-heroicon-o-document-arrow-down class="h-4 w-4" />
                        Unduh log
                    </button>
                </header>
                <ul class="mt-4 divide-y divide-zinc-100 text-sm text-zinc-600">
                    @forelse ($activities as $activity)
                        <li class="flex items-center justify-between gap-4 py-3">
                            <div class="flex flex-1 flex-col">
                                <span class="font-medium text-zinc-800">
                                    {{ $activity['judul'] ?? $activity->title ?? 'Aktivitas' }}
                                </span>
                                <span class="text-xs text-zinc-500">
                                    {{ $activity['deskripsi'] ?? $activity->description ?? 'Tidak ada deskripsi tambahan.' }}
                                </span>
                            </div>
                            <span class="text-xs text-zinc-400">
                                {{ $activity['waktu'] ?? optional($activity->created_at)->diffForHumans() ?? '-' }}
                            </span>
                        </li>
                    @empty
                        <li class="py-5 text-center text-xs text-zinc-400">
                            Aktivitas belum tersedia.
                        </li>
                    @endforelse
                </ul>
            </article>

            <article class="rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <h3 class="text-lg font-semibold text-zinc-800">Tautan Cepat</h3>
                <p class="mt-1 text-sm text-zinc-500">Aksi yang sering digunakan oleh admin.</p>
                <div class="mt-4 grid gap-3">
                    <a href="{{ route('sirekap.tenaga-kerja.create') }}" class="flex items-center justify-between rounded-xl border border-zinc-200 px-4 py-3 text-sm font-semibold text-zinc-700 hover:border-amber-300 hover:text-amber-700">
                        Tambah CPMI
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </a>
                    <a href="{{ route('sirekap.lowongan.create') }}" class="flex items-center justify-between rounded-xl border border-zinc-200 px-4 py-3 text-sm font-semibold text-zinc-700 hover:border-amber-300 hover:text-amber-700">
                        Terbitkan Lowongan
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </a>
                    <a href="{{ route('sirekap.perusahaan.index') }}" class="flex items-center justify-between rounded-xl border border-zinc-200 px-4 py-3 text-sm font-semibold text-zinc-700 hover:border-amber-300 hover:text-amber-700">
                        Lihat P3MI
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </a>
                    <a href="{{ route('sirekap.agensi.index') }}" class="flex items-center justify-between rounded-xl border border-zinc-200 px-4 py-3 text-sm font-semibold text-zinc-700 hover:border-amber-300 hover:text-amber-700">
                        Kelola Agensi
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </a>
                </div>
                <div class="mt-5 rounded-xl border border-amber-100 bg-amber-50 px-4 py-3 text-xs text-amber-700">
                    Pastikan untuk melakukan backup data berkala untuk menjaga keamanan arsip.
                </div>
            </article>
        </section>
    </div>
@endsection
