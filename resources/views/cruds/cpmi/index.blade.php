@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Disnakertrans')
@section('titleContent', 'Daftar CPMI - Tenaga Kerja')

@section('content')
    <div class="flex h-full w-full flex-col">
        <div class="border-b bg-white py-2">
            <x-navbar-crud>
                <a href="{{ route('sirekap.cpmi.create') }}"
                    class="inline-flex items-center justify-center rounded-md border border-amber-500 bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1">
                    <x-heroicon-o-plus class="mr-2 h-4 w-4" />
                    Tambah CPMI
                </a>
            </x-navbar-crud>
        </div>

        <div class="flex w-full overflow-y-auto px-4 py-6 font-inter">
            <div class="w-full space-y-4">
                @if (session('success'))
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('destroy'))
                    <div class="rounded-md border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                        {{ $errors->first('destroy') }}
                    </div>
                @endif

                <form action="{{ route('sirekap.cpmi.index') }}" method="GET"
                    class="w-full rounded-lg border border-zinc-200 bg-white p-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <input type="hidden" name="keyword" value="{{ $filters['keyword'] ?? '' }}">

                        <label class="block text-xs font-semibold uppercase text-zinc-400">
                            Jenis Kelamin
                            <select name="gender" onchange="this.form.submit()"
                                class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                <option value="">Semua</option>
                                @foreach ($genderOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(($filters['gender'] ?? '') === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block text-xs font-semibold uppercase text-zinc-400">
                            Pendidikan
                            <select name="pendidikan" onchange="this.form.submit()"
                                class="mt-1 w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                <option value="">Semua</option>
                                @foreach ($daftarPendidikan as $id => $nama)
                                    <option value="{{ $id }}" @selected(($filters['pendidikan'] ?? '') == $id)>{{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block text-xs font-semibold uppercase text-zinc-400">
                            Lowongan
                            <select name="lowongan" onchange="this.form.submit()"
                                class="mt-1 w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                <option value="">Semua</option>
                                @foreach ($daftarLowongan as $id => $nama)
                                    <option value="{{ $id }}" @selected(($filters['lowongan'] ?? '') == $id)>{{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <div class="flex items-end justify-start gap-2 sm:col-span-2 lg:col-span-1">
                            <a href="{{ route('sirekap.cpmi.index') }}"
                                class="inline-flex w-full items-center justify-center rounded-md border border-zinc-200 px-3 py-2 text-sm font-medium text-zinc-600 transition hover:border-rose-400 hover:text-rose-600 sm:w-auto">
                                Reset
                            </a>
                            <button type="submit"
                                class="inline-flex w-full items-center justify-center rounded-md border border-blue-500 bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 sm:w-auto">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </form>

                <div class="rounded-lg w-full border border-zinc-100 bg-white">
                    @if ($tenagaKerjas->isEmpty())
                        <div class="px-6 py-12 text-center text-sm text-zinc-500">
                            Belum ada data CPMI yang tersimpan.
                            <a href="{{ route('sirekap.cpmi.create') }}"
                                class="ml-1 font-medium text-emerald-600 underline underline-offset-4">
                                Tambah sekarang
                            </a>
                        </div>
                    @else
                        {{-- TABEL UNTUK LAYAR BESAR --}}
                        <div class="overflow-x-auto w-full">
                            <table class="min-w-max w-full text-sm text-zinc-600 divide-y divide-zinc-200">
                                <thead class="bg-zinc-800/80 text-xs uppercase tracking-wide text-zinc-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Nama</th>
                                        <th class="px-4 py-3 text-left">NIK</th>
                                        <th class="px-4 py-3 text-left">Kecamatan</th>
                                        <th class="px-4 py-3 text-left">Pendidikan</th>
                                        <th class="px-4 py-3 text-left">P3MI</th>
                                        <th class="px-4 py-3 text-left">Agensi</th>
                                        <th class="px-4 py-3 text-left">Job</th>
                                        <th class="px-4 py-3 text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100">
                                    @foreach ($tenagaKerjas as $tenagaKerja)
                                        <tr class="hover:bg-zinc-50/80 transition">
                                            <td class="px-4 py-3">
                                                <div class="font-semibold text-zinc-800">{{ $tenagaKerja->nama }}</div>
                                                <div class="text-xs text-zinc-500">{{ $tenagaKerja->gender }}</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="font-mono text-sm text-zinc-700">{{ $tenagaKerja->nik }}</div>
                                            </td>
                                            <td class="px-4 py-3 text-zinc-600">
                                                <div class="text-xs text-zinc-500">{{ $tenagaKerja->kecamatan }}</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-sm text-zinc-700">
                                                    {{ optional($tenagaKerja->pendidikan)->level ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-700">
                                                {{ optional($tenagaKerja->lowongan?->perusahaan)->nama ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-700">
                                                {{ optional($tenagaKerja->lowongan?->agensi)->nama ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-700">
                                                {{ optional($tenagaKerja->lowongan)->nama ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <div class="flex flex-wrap justify-end gap-2">
                                                    <a href="{{ route('sirekap.cpmi.show', $tenagaKerja) }}"
                                                        class="inline-flex items-center rounded-xl bg-zinc-100 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:bg-zinc-200">
                                                        Detail
                                                    </a>
                                                    <a href="{{ route('sirekap.cpmi.edit', $tenagaKerja) }}"
                                                        class="inline-flex items-center rounded-xl bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-200">
                                                        Ubah
                                                    </a>
                                                    <x-modal-delete action="route('sirekap.cpmi.destroy')"
                                                        title="Hapus Data">
                                                    </x-modal-delete>
                                                    {{-- <form action="{{ route('sirekap.cpmi.destroy', $tenagaKerja) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Hapus data tenaga kerja ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center rounded-xl bg-rose-100 px-3 py-1.5 text-xs font-medium text-rose-700 hover:bg-rose-200">
                                                            Hapus
                                                        </button>
                                                    </form> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>


                @if ($tenagaKerjas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div
                        class="flex flex-col gap-2 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            Menampilkan {{ $tenagaKerjas->firstItem() ?? 0 }} -
                            {{ $tenagaKerjas->lastItem() ?? 0 }}
                            dari {{ $tenagaKerjas->total() }} CPMI
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            <div class="rounded-xl border border-zinc-200 bg-white px-2 py-1">
                                {{ $tenagaKerjas->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
