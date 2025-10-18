@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Perusahaan | Detail')
@section('titleContent', 'Detail Perusahaan')

@section('content')
    <div class="h-full overflow-y-auto bg-slate-50 px-6 py-6">
        <div class="mx-auto max-w-5xl space-y-6 font-inter">
            @if (session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-zinc-800">{{ $perusahaan->nama }}</h2>
                    <p class="text-sm text-zinc-500">Profil perusahaan penempatan tenaga kerja Indonesia.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('sirekap.perusahaan.index') }}"
                        class="inline-flex items-center rounded-xl border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-emerald-400 hover:text-emerald-600">
                        <x-heroicon-o-arrow-left class="mr-2 h-4 w-4" />
                        Kembali
                    </a>
                    <a href="{{ route('sirekap.perusahaan.edit', $perusahaan) }}"
                        class="inline-flex items-center rounded-xl border border-amber-500 bg-amber-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1">
                        <x-heroicon-o-pencil-square class="mr-2 h-4 w-4" />
                        Ubah Data
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="space-y-6 lg:col-span-2">
                    <section class="rounded-3xl border border-zinc-100 bg-white p-6 shadow-sm">
                        <header class="mb-4">
                            <h3 class="text-lg font-semibold text-zinc-800">Informasi Perusahaan</h3>
                            <p class="text-sm text-zinc-500">Identitas utama dan kontak pengelola.</p>
                        </header>
                        <dl class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">Nama Perusahaan</dt>
                                <dd class="text-sm text-zinc-700">{{ $perusahaan->nama }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">Nama Pimpinan</dt>
                                <dd class="text-sm text-zinc-700">
                                    {{ $perusahaan->nama_pimpinan ?? 'Belum diisi' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">Email</dt>
                                <dd class="text-sm text-zinc-700">
                                    {{ $perusahaan->email ?? '-' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">Nomor HP</dt>
                                <dd class="text-sm text-zinc-700">
                                    {{ $perusahaan->nomor_hp ?? '-' }}
                                </dd>
                            </div>
                        </dl>
                        <div class="mt-6">
                            <dt class="text-xs uppercase tracking-wide text-zinc-400">Alamat</dt>
                            <dd class="mt-1 whitespace-pre-line text-sm text-zinc-700">
                                {{ $perusahaan->alamat ?? 'Belum diisi' }}
                            </dd>
                        </div>
                        @if ($perusahaan->icon_url)
                            <div class="mt-6">
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">Icon / Logo</dt>
                                <dd class="mt-1 flex items-center gap-3">
                                    <img src="{{ $perusahaan->icon_url }}" alt="Logo {{ $perusahaan->nama }}"
                                        class="h-12 w-12 rounded-lg border border-zinc-200 object-cover"
                                        onerror="this.style.display='none'">
                                    <span class="text-sm text-zinc-600 break-all">{{ $perusahaan->icon }}</span>
                                </dd>
                            </div>
                        @endif
                    </section>
                </div>

                <aside class="space-y-6">
                    <section class="rounded-3xl border border-zinc-100 bg-white p-6 shadow-sm">
                        <h3 class="text-base font-semibold text-zinc-800">Ringkasan</h3>
                        <dl class="mt-4 space-y-3 text-sm text-zinc-600">
                            <div class="flex items-start justify-between">
                                <dt class="text-zinc-500">Dibuat</dt>
                                <dd class="text-right text-zinc-700">
                                    {{ $perusahaan->created_at?->translatedFormat('d M Y H:i') ?? '-' }}
                                </dd>
                            </div>
                            <div class="flex items-start justify-between">
                                <dt class="text-zinc-500">Diperbarui</dt>
                                <dd class="text-right text-zinc-700">
                                    {{ $perusahaan->updated_at?->translatedFormat('d M Y H:i') ?? '-' }}
                                </dd>
                            </div>
                        </dl>
                    </section>

                    <section class="rounded-3xl border border-zinc-100 bg-white p-6 shadow-sm">
                        <h3 class="text-base font-semibold text-zinc-800">Tindakan Cepat</h3>
                        <div class="mt-4 space-y-3 text-sm">
                            <a href="{{ route('sirekap.perusahaan.edit', $perusahaan) }}"
                                class="flex items-center justify-between rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 font-medium text-amber-700 transition hover:border-amber-300 hover:bg-amber-100">
                                Ubah data perusahaan
                                <x-heroicon-o-pencil-square class="h-4 w-4" />
                            </a>
                            <form action="{{ route('sirekap.perusahaan.destroy', $perusahaan) }}" method="POST"
                                onsubmit="return confirm('Hapus data perusahaan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="flex w-full items-center justify-between rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 font-medium text-rose-700 transition hover:border-rose-300 hover:bg-rose-100">
                                    Hapus perusahaan
                                    <x-heroicon-o-trash class="h-4 w-4" />
                                </button>
                            </form>
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </div>
@endsection

