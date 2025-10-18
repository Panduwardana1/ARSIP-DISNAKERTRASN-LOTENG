@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Perusahaan | Disnakertrans')
@section('titleContent', 'Daftar Perusahaan Indonesia')
@vite('resources/css/app.css')
@section('content')
    <div class="flex h-full flex-col">
        <div class="border-b bg-white">
            <div
                class="mx-auto flex items-center max-w-6xl flex-col gap-3 px-4 py-2 font-inter sm:flex-row sm:items-center sm:justify-between">
                <x-search-data class="w-full sm:max-w-sm" :action="route('sirekap.perusahaan.index')" placeholder="Cari nama agensi" name="keyword" />
                <div class="gap-2 sm:w-auto sm:flex-row sm:items-center sm:justify-end">
                    <x-button href="{{ route('sirekap.perusahaan.create') }}" color="teal"
                        class="justify-center items-center">
                        <x-heroicon-o-plus class="h-5 w-5" />
                        Tambah
                    </x-button>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-4 font-inter">
            <div class="mx-auto max-w-6xl space-y-4">
                @if (session('success'))
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('destroy'))
                    <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                        {{ $errors->first('destroy') }}
                    </div>
                @endif

                <div class="rounded-lg border border-zinc-300 bg-white">
                    @if ($perusahaans->count())
                        <div class="hidden md:block">
                            <table class="min-w-full divide-y divide-zinc-300 text-sm text-zinc-600">
                                <thead>
                                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                                        <th class="px-6 py-4">Nama Perusahaan</th>
                                        <th class="px-6 py-4">Kontak</th>
                                        <th class="px-6 py-4">Alamat</th>
                                        <th class="px-6 py-4">Logo</th>
                                        <th class="px-6 py-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100">
                                    @foreach ($perusahaans as $perusahaan)
                                        <tr class="align-content-center items-center">
                                            <td class="px-6 py-4">
                                                <div class="font-semibold text-zinc-800">{{ $perusahaan->nama }}</div>
                                                <div class="text-xs text-zinc-500">
                                                    {{ $perusahaan->nama_pimpinan ?? 'Pimpinan belum diisi' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div>{{ $perusahaan->email ?? '-' }}</div>
                                                <div class="text-xs text-zinc-500">{{ $perusahaan->nomor_hp ?? '-' }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($perusahaan->alamat)
                                                    <div class="whitespace-pre-line text-sm text-zinc-600">
                                                        {{ $perusahaan->alamat }}
                                                    </div>
                                                @else
                                                    <span class="text-xs text-zinc-400">Alamat belum diisi</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($perusahaan->gambar)
                                                    <div class="flex items-center gap-2">
                                                        <img src="{{ Storage::url($perusahaan->gambar) }}"
                                                            alt="Logo {{ $perusahaan->nama }}"
                                                            class="h-8 w-8 rounded-md object-cover"
                                                            onerror="this.style.display='none'">
                                                    </div>
                                                @else
                                                    <span class="text-xs text-zinc-400">Tidak ada Gambar</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex justify-end gap-2 text-xs">
                                                    <a href="{{ route('sirekap.perusahaan.show', $perusahaan) }}"
                                                        class="inline-flex items-center rounded-md border border-transparent bg-zinc-100 px-3 py-1.5 font-medium text-zinc-600 transition hover:bg-zinc-200">
                                                        Detail
                                                    </a>
                                                    <a href="{{ route('sirekap.perusahaan.edit', $perusahaan) }}"
                                                        class="inline-flex items-center rounded-md border border-transparent bg-amber-100 px-3 py-1.5 font-medium text-amber-700 transition hover:bg-amber-200">
                                                        Ubah
                                                    </a>

                                                    <x-modal-delete
                                                        action="{{ route('sirekap.perusahaan.destroy', $perusahaan) }}"
                                                        title="Peringatan"
                                                        message="Tindakan ini tidak dapat dibatalkan. Yakin ingin menghapus data ini?"
                                                        confirmText="OK" cancelText="BATAL">
                                                    </x-modal-delete>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="divide-y divide-zinc-100 md:hidden">
                            @foreach ($perusahaans as $perusahaan)
                                <article class="space-y-3 p-4">
                                    <div class="flex flex-col gap-2">
                                        <div>
                                            <h3 class="text-base font-semibold text-zinc-800">{{ $perusahaan->nama }}</h3>
                                            <p class="text-xs text-zinc-500">
                                                {{ $perusahaan->nama_pimpinan ?? 'Pimpinan belum diisi' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-2 text-sm text-zinc-600">
                                        <p><span class="text-xs uppercase text-zinc-400">Email</span><br>
                                            {{ $perusahaan->email ?? '-' }}
                                        </p>
                                        <p><span class="text-xs uppercase text-zinc-400">Nomor HP</span><br>
                                            {{ $perusahaan->nomor_hp ?? '-' }}
                                        </p>
                                        <p><span class="text-xs uppercase text-zinc-400">Alamat</span><br>
                                            {{ $perusahaan->alamat ?? 'Belum diisi' }}
                                        </p>
                                        <p>
                                            <span class="text-xs uppercase text-zinc-400">Icon</span><br>
                                            @if ($perusahaan->icon_url)
                                                <span class="flex items-center gap-2">
                                                    <img src="{{ $perusahaan->icon_url }}"
                                                        alt="Logo {{ $perusahaan->nama }}"
                                                        class="h-8 w-8 rounded-md border border-zinc-200 object-cover"
                                                        onerror="this.style.display='none'">
                                                    <span
                                                        class="text-xs text-zinc-500 break-all">{{ $perusahaan->icon }}</span>
                                                </span>
                                            @else
                                                <span class="text-xs text-zinc-400">Tidak ada icon</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="flex flex-wrap gap-2 text-xs">
                                        <a href="{{ route('sirekap.perusahaan.show', $perusahaan) }}"
                                            class="inline-flex items-center rounded-lg border border-transparent bg-zinc-100 px-3 py-1.5 font-medium text-zinc-600 transition hover:bg-zinc-200">
                                            Detail
                                        </a>
                                        <a href="{{ route('sirekap.perusahaan.edit', $perusahaan) }}"
                                            class="inline-flex items-center rounded-lg border border-transparent bg-amber-100 px-3 py-1.5 font-medium text-amber-700 transition hover:bg-amber-200">
                                            Ubah
                                        </a>
                                        <form action="{{ route('sirekap.perusahaan.destroy', $perusahaan) }}"
                                            method="POST" onsubmit="return confirm('Hapus data perusahaan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center rounded-lg border border-transparent bg-rose-100 px-3 py-1.5 font-medium text-rose-700 transition hover:bg-rose-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="px-6 py-12 text-center text-sm text-zinc-500">
                            Belum ada data perusahaan yang tersimpan.
                            <a href="{{ route('sirekap.perusahaan.create') }}"
                                class="ml-1 font-medium text-emerald-600 underline underline-offset-4">
                                Tambah sekarang
                            </a>
                        </div>
                    @endif
                </div>

                @if ($perusahaans instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div
                        class="flex flex-col gap-3 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            Menampilkan {{ $perusahaans->firstItem() ?? 0 }} - {{ $perusahaans->lastItem() ?? 0 }}
                            dari {{ $perusahaans->total() }} perusahaan
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            <div class="rounded-xl border border-zinc-200 bg-white px-3 py-1.5">
                                {{ $perusahaans->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
