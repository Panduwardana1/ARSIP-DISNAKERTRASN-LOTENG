@extends('layouts.app')

@section('pageTitle', 'Dashboard')
@section('titlePageContent', 'Dashboard Overview')
<link rel="icon" href="{{ asset('asset/logo.png') }}">

@section('content')
    <div class="min-h-screen p-3">
        <div class="mx-auto max-w-full space-y-4">
            <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                {{-- total CPMI --}}
                <div class="rounded-xl border border-neutral-300 bg-neutral-100">
                    <div class="flex items-center p-2 gap-2 border-b border-neutral-300">
                        <span class="rounded-md bg-teal-600 p-2">
                            <x-heroicon-o-user class="h-6 w-6 text-white" />
                        </span>
                        <div class="space-y-0">
                            <span
                                class="text-xl font-semibold font-manrope uppercase tracking-wide text-neutral-800">CPMI</span>
                            <p class=" text-xs font-manrope font-medium text-neutral-500">Total CPMI terdata</p>
                        </div>
                    </div>
                    <p class="p-3 text-3xl text-center font-semibold font-manrope text-neutral-800">1.284</p>
                </div>
                <div class="rounded-xl border border-neutral-300 bg-neutral-100">
                    <div class="flex items-center p-2 gap-2 border-b border-neutral-300">
                        <span class="rounded-md bg-sky-600 p-2">
                            <x-heroicon-o-building-office-2 class="h-6 w-6 text-white" />
                        </span>
                        <div class="space-y-0">
                            <span
                                class="text-xl font-semibold font-manrope uppercase tracking-wide text-neutral-800">P3MI</span>
                            <p class=" text-xs font-manrope font-medium text-neutral-500">Total perusahaan terdata</p>
                        </div>
                    </div>
                    <p class="p-3 text-3xl text-center font-semibold font-manrope text-neutral-800">1.284</p>
                </div>
                <div class="rounded-xl border border-neutral-300 bg-neutral-100">
                    <div class="flex items-center p-2 gap-2 border-b border-neutral-300">
                        <span class="rounded-md bg-amber-600 p-2">
                            <x-heroicon-o-briefcase class="h-6 w-6 text-white" />
                        </span>
                        <div class="space-y-0">
                            <span
                                class="text-xl font-semibold font-manrope uppercase tracking-wide text-neutral-800">CPMI</span>
                            <p class=" text-xs font-manrope font-medium text-neutral-500">Total CPMI terdata</p>
                        </div>
                    </div>
                    <p class="p-3 text-3xl text-center font-semibold font-manrope text-neutral-800">1.284</p>
                </div>
                <div class="rounded-xl border border-neutral-300 bg-neutral-100">
                    <div class="flex items-center p-2 gap-2 border-b border-neutral-300">
                        <span class="rounded-md bg-teal-600 p-2">
                            <x-heroicon-o-user class="h-6 w-6 text-white" />
                        </span>
                        <div class="space-y-0">
                            <span
                                class="text-xl font-semibold font-manrope uppercase tracking-wide text-neutral-800">CPMI</span>
                            <p class=" text-xs font-manrope font-medium text-neutral-500">Total CPMI terdata</p>
                        </div>
                    </div>
                    <p class="p-3 text-3xl text-center font-semibold font-manrope text-neutral-800">1.284</p>
                </div>
            </section>

            <section class="grid gap-6 xl:grid-cols-3">
                <div class="space-y-6 rounded-xl border border-neutral-200 bg-white p-6 xl:col-span-2">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div>
                            <h2 class="text-lg font-semibold font-manrope text-neutral-900">Rekap Arsip per Jenis</h2>
                            <p class="text-sm text-neutral-500">Distribusi dokumen CPMI yang tersimpan dalam sistem</p>
                        </div>
                        <button
                            class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 px-3 py-2 text-sm font-medium text-neutral-600 transition hover:border-neutral-300 hover:text-neutral-800">
                            <x-heroicon-o-arrow-path class="h-4 w-4" />
                            Sinkronkan
                        </button>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-xl bg-sky-50 p-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-sky-600">Perjanjian Kerja</p>
                                <span class="text-xs font-semibold font-manrope text-sky-500">512 arsip</span>
                            </div>
                            <div class="mt-3 h-2 rounded-full bg-sky-100">
                                <div class="h-full w-4/5 rounded-full bg-sky-500"></div>
                            </div>
                            <p class="mt-2 text-xs text-sky-700">80% telah terverifikasi</p>
                        </div>
                        <div class="rounded-xl bg-emerald-50 p-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-emerald-600">Surat Rekomendasi</p>
                                <span class="text-xs font-semibold font-manrope text-emerald-500">326 arsip</span>
                            </div>
                            <div class="mt-3 h-2 rounded-full bg-emerald-100">
                                <div class="h-full w-2/3 rounded-full bg-emerald-500"></div>
                            </div>
                            <p class="mt-2 text-xs text-emerald-700">66% dalam antrian validasi</p>
                        </div>
                        <div class="rounded-xl bg-amber-50 p-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-amber-600">Data Pelatihan</p>
                                <span class="text-xs font-semibold font-manrope text-amber-500">214 arsip</span>
                            </div>
                            <div class="mt-3 h-2 rounded-full bg-amber-100">
                                <div class="h-full w-1/2 rounded-full bg-amber-500"></div>
                            </div>
                            <p class="mt-2 text-xs text-amber-700">50% menunggu lampiran</p>
                        </div>
                        <div class="rounded-xl bg-rose-50 p-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-rose-600">Pengaduan</p>
                                <span class="text-xs font-semibold font-manrope text-rose-500">64 arsip</span>
                            </div>
                            <div class="mt-3 h-2 rounded-full bg-rose-100">
                                <div class="h-full w-1/3 rounded-full bg-rose-500"></div>
                            </div>
                            <p class="mt-2 text-xs text-rose-700">Prioritas tindak lanjut</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-5 rounded-xl border border-neutral-200 bg-white p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold font-manrope text-neutral-900">Aktivitas Terbaru</h2>
                        <a href="#" class="text-sm font-medium text-sky-500 hover:text-sky-600">Lihat semua</a>
                    </div>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3 border-b border-neutral-100 pb-4 last:border-0 last:pb-0">
                            <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                            <div>
                                <p class="font-medium text-neutral-800">Budi Setiawan mengunggah perjanjian kerja baru</p>
                                <p class="text-xs text-neutral-500">10 menit lalu • Pengajuan CPMI</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 border-b border-neutral-100 pb-4 last:border-0 last:pb-0">
                            <span class="mt-1 h-2 w-2 rounded-full bg-amber-500"></span>
                            <div>
                                <p class="font-medium text-neutral-800">Validasi arsip pelatihan menunggu konfirmasi</p>
                                <p class="text-xs text-neutral-500">45 menit lalu • Tim Verifikasi</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 border-b border-neutral-100 pb-4 last:border-0 last:pb-0">
                            <span class="mt-1 h-2 w-2 rounded-full bg-sky-500"></span>
                            <div>
                                <p class="font-medium text-neutral-800">Sinkronisasi data CPMI ke sistem pusat berhasil</p>
                                <p class="text-xs text-neutral-500">2 jam lalu • Integrasi Sistem</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2 w-2 rounded-full bg-rose-500"></span>
                            <div>
                                <p class="font-medium text-neutral-800">Tindak lanjut pengaduan tenaga kerja #3412</p>
                                <p class="text-xs text-neutral-500">Kemarin • Unit Pelayanan</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>

            <section class="rounded-xl border border-neutral-200 bg-white p-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold font-manrope text-neutral-900">Arsip Terbaru</h2>
                        <p class="text-sm text-neutral-500">Daftar berkas yang baru masuk ke sistem dalam 7 hari terakhir
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <button
                            class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 px-3 py-2 text-sm font-medium text-neutral-600 transition hover:border-neutral-300 hover:text-neutral-800">
                            <x-heroicon-o-funnel class="h-4 w-4" />
                            Filter
                        </button>
                        <button
                            class="inline-flex items-center gap-2 rounded-lg bg-sky-500 px-3 py-2 text-sm font-semibold font-manrope text-white transition hover:bg-sky-600">
                            <x-heroicon-o-arrow-down-on-square-stack class="h-4 w-4" />
                            Ekspor
                        </button>
                    </div>
                </div>
                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200 text-sm">
                        <thead class="bg-neutral-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 text-left font-medium uppercase tracking-wide text-neutral-500">Nomor
                                    Arsip</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left font-medium uppercase tracking-wide text-neutral-500">Nama
                                    CPMI</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left font-medium uppercase tracking-wide text-neutral-500">Jenis
                                    Dokumen</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left font-medium uppercase tracking-wide text-neutral-500">Status
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left font-medium uppercase tracking-wide text-neutral-500">
                                    Diperbarui</th>
                                <th scope="col"
                                    class="px-4 py-3 text-right font-medium uppercase tracking-wide text-neutral-500">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100 text-neutral-700">
                            <tr class="transition hover:bg-neutral-50">
                                <td class="px-4 py-3 font-medium text-neutral-900">ARS-2024-0912</td>
                                <td class="px-4 py-3">Siti Nurhaliza</td>
                                <td class="px-4 py-3">Perjanjian Kerja</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold font-manrope text-emerald-600">Terverifikasi</span>
                                </td>
                                <td class="px-4 py-3">12 Maret 2024</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="#"
                                        class="text-sm font-semibold font-manrope text-sky-500 hover:text-sky-600">Detail</a>
                                </td>
                            </tr>
                            <tr class="transition hover:bg-neutral-50">
                                <td class="px-4 py-3 font-medium text-neutral-900">ARS-2024-0908</td>
                                <td class="px-4 py-3">Budi Santoso</td>
                                <td class="px-4 py-3">Data Pelatihan</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold font-manrope text-amber-600">Proses</span>
                                </td>
                                <td class="px-4 py-3">11 Maret 2024</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="#"
                                        class="text-sm font-semibold font-manrope text-sky-500 hover:text-sky-600">Detail</a>
                                </td>
                            </tr>
                            <tr class="transition hover:bg-neutral-50">
                                <td class="px-4 py-3 font-medium text-neutral-900">ARS-2024-0902</td>
                                <td class="px-4 py-3">Rina Wijaya</td>
                                <td class="px-4 py-3">Surat Rekomendasi</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex items-center rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold font-manrope text-rose-600">Revisi</span>
                                </td>
                                <td class="px-4 py-3">9 Maret 2024</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="#"
                                        class="text-sm font-semibold font-manrope text-sky-500 hover:text-sky-600">Detail</a>
                                </td>
                            </tr>
                            <tr class="transition hover:bg-neutral-50">
                                <td class="px-4 py-3 font-medium text-neutral-900">ARS-2024-0896</td>
                                <td class="px-4 py-3">Ahmad Fauzi</td>
                                <td class="px-4 py-3">Pengaduan</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex items-center rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold font-manrope text-rose-600">Butuh
                                        Tindak</span>
                                </td>
                                <td class="px-4 py-3">8 Maret 2024</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="#"
                                        class="text-sm font-semibold font-manrope text-sky-500 hover:text-sky-600">Detail</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
@endsection
