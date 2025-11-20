@extends('layouts.app')

@section('pageTitle', 'Profil Pengguna')

@section('content')
    <section class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-cyan-50 py-10">
        <div class="mx-auto max-w-6xl px-4 space-y-6">
            <header class="rounded-2xl border border-emerald-100 bg-white/80 p-6 shadow-sm backdrop-blur">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="h-16 w-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-cyan-500 text-white shadow-lg flex items-center justify-center text-xl font-semibold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-wide text-emerald-600">Akun Terverifikasi</p>
                            <h1 class="text-2xl font-semibold text-zinc-900">{{ auth()->user()->name ?? 'Nama Pengguna' }}
                            </h1>
                            <p class="text-sm text-zinc-600">{{ auth()->user()->email ?? 'user@email.com' }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="#"
                            class="rounded-lg border border-emerald-200 px-4 py-2 text-sm font-medium text-emerald-700 transition hover:bg-emerald-50">
                            Edit Profil
                        </a>
                        <a href="#"
                            class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-500">
                            Kelola Akun
                        </a>
                    </div>
                </div>
            </header>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="space-y-6 lg:col-span-2">
                    <div class="rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-zinc-900">Ringkasan</h2>
                                <p class="text-sm text-zinc-500">Status terbaru dan progres aktivitas.</p>
                            </div>
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                Aktif
                            </span>
                        </div>
                        <div class="mt-4 grid gap-4 sm:grid-cols-3">
                            <div class="rounded-xl border border-emerald-50 bg-emerald-50/60 p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-emerald-700">Tugas selesai</p>
                                <p class="mt-2 text-2xl font-semibold text-emerald-900">24</p>
                                <p class="text-xs text-emerald-700">+3 minggu ini</p>
                            </div>
                            <div class="rounded-xl border border-cyan-50 bg-cyan-50/70 p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-cyan-700">Proyek aktif</p>
                                <p class="mt-2 text-2xl font-semibold text-cyan-900">5</p>
                                <p class="text-xs text-cyan-700">2 segera jatuh tempo</p>
                            </div>
                            <div class="rounded-xl border border-amber-50 bg-amber-50 p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-amber-700">Jam kontribusi</p>
                                <p class="mt-2 text-2xl font-semibold text-amber-900">128</p>
                                <p class="text-xs text-amber-700">+12 bulan ini</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-zinc-100 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-zinc-900">Aktivitas Terbaru</h2>
                        <p class="text-sm text-zinc-500">Riwayat singkat perubahan dan catatan.</p>
                        <div class="mt-4 space-y-4">
                            @foreach ([['title' => 'Memperbarui data pendidikan', 'time' => '2 jam yang lalu', 'badge' => 'Pendidikan'], ['title' => 'Menambahkan agency baru', 'time' => 'Kemarin', 'badge' => 'Agency'], ['title' => 'Sinkronisasi data CPMI', 'time' => '3 hari lalu', 'badge' => 'Tenaga Kerja']] as $item)
                                <div class="flex items-start gap-3 rounded-xl border border-zinc-100 p-3">
                                    <div class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-zinc-900">{{ $item['title'] }}</p>
                                        <p class="text-xs text-zinc-500">{{ $item['time'] }}</p>
                                    </div>
                                    <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-700">
                                        {{ $item['badge'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <aside class="space-y-6">
                    <div class="rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-zinc-900">Informasi Kontak</h3>
                        <dl class="mt-4 space-y-3 text-sm text-zinc-700">
                            <div class="flex items-start justify-between gap-3">
                                <dt class="text-zinc-500">Email</dt>
                                <dd class="font-medium text-zinc-900 text-right">{{ auth()->user()->email ?? '-' }}</dd>
                            </div>
                            <div class="flex items-start justify-between gap-3">
                                <dt class="text-zinc-500">Telepon</dt>
                                <dd class="font-medium text-zinc-900 text-right">+62 812 3456 7890</dd>
                            </div>
                            <div class="flex items-start justify-between gap-3">
                                <dt class="text-zinc-500">Lokasi</dt>
                                <dd class="font-medium text-zinc-900 text-right">Jakarta, Indonesia</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="rounded-2xl border border-cyan-100 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-zinc-900">Preferensi</h3>
                        <div class="mt-3 space-y-3 text-sm text-zinc-700">
                            <label
                                class="flex items-center justify-between gap-4 rounded-xl border border-zinc-100 px-3 py-2">
                                <span>Notifikasi email</span>
                                <input type="checkbox" checked
                                    class="h-5 w-5 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500">
                            </label>
                            <label
                                class="flex items-center justify-between gap-4 rounded-xl border border-zinc-100 px-3 py-2">
                                <span>Tampilkan status online</span>
                                <input type="checkbox"
                                    class="h-5 w-5 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500">
                            </label>
                            <label
                                class="flex items-center justify-between gap-4 rounded-xl border border-zinc-100 px-3 py-2">
                                <span>Mode fokus</span>
                                <input type="checkbox"
                                    class="h-5 w-5 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500">
                            </label>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
