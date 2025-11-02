@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI')
@section('titlePageContent', 'Daftar CPMI')

@section('content')
    <div class="flex h-full flex-col font-inter">
        <main class="flex-1 px-4 py-6">
            <div class="flex flex-col gap-3 pb-4 md:flex-row md:items-center md:justify-between">
                {{-- search --}}
                <form method="GET" action="{{ route('sirekap.tenaga-kerja.index') }}" class="relative w-full max-w-md"
                    role="search">
                    @foreach (request()->except('q', 'page') as $queryName => $queryValue)
                        @if (is_scalar($queryValue))
                            <input type="hidden" name="{{ $queryName }}" value="{{ $queryValue }}">
                        @endif
                    @endforeach

                    <span class="pointer-events-none absolute inset-y-0 left-3 inline-flex items-center">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5" />
                    </span>

                    <input id="search" name="q" type="search" placeholder="Cari nama atau NIK CPMI"
                        value="{{ request('q') }}"
                        class="peer w-full rounded-md border border-zinc-300 bg-zinc-100 py-2 pl-9 pr-9 text-sm text-zinc-700 placeholder:text-zinc-400 hover:border-zinc-400 focus:border-amber-500 focus:outline-none focus:ring-0" />

                    @if (filled(request('q')))
                        <a href="{{ route('sirekap.tenaga-kerja.index', request()->except('q', 'page')) }}"
                            class="absolute inset-y-0 right-2 my-auto inline-flex items-center rounded-full px-2 text-xs text-zinc-500 hover:text-zinc-800"
                            aria-label="Bersihkan pencarian">
                            Clear
                        </a>
                    @endif
                </form>

                {{-- button add --}}
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('sirekap.tenaga-kerja.create') }}"
                        class="inline-flex items-center gap-2 rounded-md bg-green-600 px-3 py-1.5 text-sm font-semibold text-white shadow hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
                        <x-heroicon-s-plus class="h-5 w-5" />
                        Tambah CPMI
                    </a>
                </div>
            </div>

            <div class="mx-auto max-w-full space-y-6">
                @if (session('success'))
                    <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('db'))
                    <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                        {{ $errors->first('db') }}
                    </div>
                @endif

                @if ($errors->has('app'))
                    <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-700">
                        {{ $errors->first('app') }}
                    </div>
                @endif

                <div class="rounded-md border border-zinc-200 bg-white">
                    @if ($tenagaKerjas->count())
                        <div class="hidden overflow-x-auto md:block">
                            <table class="min-w-full divide-y divide-zinc-200 text-sm text-zinc-600">
                                <thead>
                                    <tr class="bg-zinc-100 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                                        <th class="px-6 py-4">Identitas</th>
                                        <th class="px-6 py-4">Domisili</th>
                                        <th class="px-6 py-4">Pendidikan &amp; Penempatan</th>
                                        <th class="px-6 py-4">Dibuat</th>
                                        <th class="px-6 py-4 text-right">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100">
                                    @foreach ($tenagaKerjas as $tenagaKerja)
                                        <tr class="transition hover:bg-zinc-50/70">
                                            <td class="px-6 py-4 align-top">
                                                <div class="font-semibold text-zinc-800">{{ $tenagaKerja->nama }}</div>
                                                <div class="mt-1 text-xs text-zinc-500">
                                                    <span class="font-mono text-zinc-600">{{ $tenagaKerja->nik }}</span>
                                                    <span class="px-1 text-zinc-300">|</span>
                                                    {{ $tenagaKerja->gender ? $tenagaKerja->getLabelGender() : 'Gender belum diisi' }}
                                                </div>
                                                <div class="mt-1 text-xs text-zinc-500">
                                                    Email:
                                                    {{ $tenagaKerja->email ?: 'Tidak diisi' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <div class="text-sm font-medium text-zinc-800">
                                                    {{ optional($tenagaKerja->desa)->nama ?? '-' }}
                                                </div>
                                                <div class="text-xs text-zinc-500">
                                                    Kecamatan {{ optional(optional($tenagaKerja->desa)->kecamatan)->nama ?? optional($tenagaKerja->kecamatan)->nama ?? '-' }}
                                                </div>
                                                <div class="mt-1 text-xs text-zinc-500">
                                                    {{ $tenagaKerja->alamat_lengkap ?: 'Alamat belum diisi' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <div class="space-y-1 text-xs text-zinc-500">
                                                    <div>
                                                        <span class="font-semibold text-zinc-700">Pendidikan:</span>
                                                        {{ optional($tenagaKerja->pendidikan)->nama ?? '-' }}
                                                    </div>
                                                    <div>
                                                        <span class="font-semibold text-zinc-700">P3MI:</span>
                                                        {{ optional($tenagaKerja->perusahaan)->nama ?? '-' }}
                                                    </div>
                                                    <div>
                                                        <span class="font-semibold text-zinc-700">Agensi:</span>
                                                        {{ optional($tenagaKerja->agency)->nama ?? '-' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <div class="text-sm font-medium text-zinc-800">
                                                    {{ $tenagaKerja->created_at?->translatedFormat('d M Y') ?? '-' }}
                                                </div>
                                                <div class="text-xs text-zinc-500">
                                                    Diperbarui {{ $tenagaKerja->updated_at?->diffForHumans() ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('sirekap.tenaga-kerja.show', $tenagaKerja) }}"
                                                        class="inline-flex items-center justify-center rounded-md bg-blue-500 px-2 py-1.5 text-xs font-medium text-blue-50 transition hover:bg-blue-600"
                                                        aria-label="Lihat detail {{ $tenagaKerja->nama }}">
                                                        <x-heroicon-o-eye class="h-4 w-4" />
                                                    </a>
                                                    <a href="{{ route('sirekap.tenaga-kerja.edit', $tenagaKerja) }}"
                                                        class="inline-flex items-center justify-center rounded-md bg-amber-500 px-2 py-1.5 text-xs font-medium text-amber-50 transition hover:bg-amber-600"
                                                        aria-label="Ubah data {{ $tenagaKerja->nama }}">
                                                        <x-heroicon-o-pencil-square class="h-4 w-4" />
                                                    </a>
                                                    <x-modal-delete :action="route('sirekap.tenaga-kerja.destroy', $tenagaKerja)"
                                                        title="Arsipkan CPMI" message="Data akan dipindahkan ke arsip. Lanjutkan?">
                                                    </x-modal-delete>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="space-y-4 px-4 py-5 md:hidden">
                            @foreach ($tenagaKerjas as $tenagaKerja)
                                <article class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
                                    <header class="flex items-start justify-between gap-4">
                                        <div>
                                            <h3 class="text-base font-semibold text-zinc-900">{{ $tenagaKerja->nama }}</h3>
                                            <p class="text-xs text-zinc-500">
                                                NIK {{ $tenagaKerja->nik }}
                                                <span class="px-1 text-zinc-300">|</span>
                                                {{ $tenagaKerja->gender ? $tenagaKerja->getLabelGender() : '-' }}
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('sirekap.tenaga-kerja.show', $tenagaKerja) }}"
                                                class="inline-flex items-center justify-center rounded-md bg-blue-500 p-1.5 text-xs font-medium text-blue-50 transition hover:bg-blue-600"
                                                aria-label="Detail {{ $tenagaKerja->nama }}">
                                                <x-heroicon-o-eye class="h-4 w-4" />
                                            </a>
                                            <a href="{{ route('sirekap.tenaga-kerja.edit', $tenagaKerja) }}"
                                                class="inline-flex items-center justify-center rounded-md bg-amber-500 p-1.5 text-xs font-medium text-amber-50 transition hover:bg-amber-600"
                                                aria-label="Ubah {{ $tenagaKerja->nama }}">
                                                <x-heroicon-o-pencil-square class="h-4 w-4" />
                                            </a>
                                        </div>
                                    </header>

                                    <dl class="mt-4 space-y-3 text-xs text-zinc-500">
                                        <div>
                                            <dt class="text-[11px] uppercase tracking-wide text-zinc-400">Email</dt>
                                            <dd class="mt-1 text-sm text-zinc-700">
                                                {{ $tenagaKerja->email ?: 'Tidak diisi' }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-[11px] uppercase tracking-wide text-zinc-400">Domisili</dt>
                                            <dd class="mt-1 text-sm text-zinc-700">
                                                {{ optional($tenagaKerja->desa)->nama ?? '-' }},
                                                {{ optional(optional($tenagaKerja->desa)->kecamatan)->nama ?? optional($tenagaKerja->kecamatan)->nama ?? '-' }}
                                            </dd>
                                            <dd class="mt-1 text-xs text-zinc-500">
                                                {{ $tenagaKerja->alamat_lengkap ?: 'Alamat belum diisi' }}
                                            </dd>
                                        </div>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <dt class="text-[11px] uppercase tracking-wide text-zinc-400">Pendidikan</dt>
                                                <dd class="mt-1 text-sm text-zinc-700">
                                                    {{ optional($tenagaKerja->pendidikan)->nama ?? '-' }}
                                                </dd>
                                            </div>
                                            <div>
                                                <dt class="text-[11px] uppercase tracking-wide text-zinc-400">P3MI</dt>
                                                <dd class="mt-1 text-sm text-zinc-700">
                                                    {{ optional($tenagaKerja->perusahaan)->nama ?? '-' }}
                                                </dd>
                                            </div>
                                            <div>
                                                <dt class="text-[11px] uppercase tracking-wide text-zinc-400">Agensi</dt>
                                                <dd class="mt-1 text-sm text-zinc-700">
                                                    {{ optional($tenagaKerja->agency)->nama ?? '-' }}
                                                </dd>
                                            </div>
                                            <div>
                                                <dt class="text-[11px] uppercase tracking-wide text-zinc-400">Dibuat</dt>
                                                <dd class="mt-1 text-sm text-zinc-700">
                                                    {{ $tenagaKerja->created_at?->translatedFormat('d M Y') ?? '-' }}
                                                </dd>
                                            </div>
                                        </div>
                                    </dl>

                                    <div class="mt-4">
                                        <x-modal-delete :action="route('sirekap.tenaga-kerja.destroy', $tenagaKerja)"
                                            title="Arsipkan CPMI" message="Data akan dipindahkan ke arsip. Lanjutkan?">
                                        </x-modal-delete>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="px-6 py-12 text-center text-sm text-zinc-500">
                            Belum ada data CPMI yang tersimpan.
                            <a href="{{ route('sirekap.tenaga-kerja.create') }}"
                                class="ml-1 font-medium text-amber-600 underline underline-offset-4">
                                Tambah sekarang
                            </a>
                        </div>
                    @endif
                </div>

                @if ($tenagaKerjas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div
                        class="flex flex-col gap-2 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            Menampilkan {{ $tenagaKerjas->firstItem() ?? 0 }} - {{ $tenagaKerjas->lastItem() ?? 0 }} dari
                            {{ $tenagaKerjas->total() }} CPMI
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            {{-- {{ $tenagaKerjas->withQueryString()->links('components.pagination.simple') }} --}}
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
