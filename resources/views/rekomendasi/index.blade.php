@extends('layouts.app')

@section('pageTitle', 'SIREKAP - Rekomendasi Paspor')
@section('Title', 'Rekomendasi Paspor')

@section('content')
    <div class="space-y-4">
        <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
            <form method="GET" action="{{ route('sirekap.rekomendasi.index') }}" class="flex flex-col gap-3 md:flex-row">
                <div class="flex-1">
                    <label for="q" class="text-sm font-semibold text-zinc-600">Cari tenaga kerja</label>
                    <input type="text" id="q" name="q" value="{{ request('q') }}"
                        class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900"
                        placeholder="Masukkan nama atau NIK">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Cari
                    </button>
                    <a href="{{ route('sirekap.rekomendasi.index') }}"
                        class="rounded-lg border border-zinc-200 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @if (session('rekomendasi_baru'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                Rekomendasi terbaru siap dicetak.
                <a href="{{ route('sirekap.rekomendasi.export', session('rekomendasi_baru')) }}"
                    class="font-semibold underline underline-offset-2">Klik di sini untuk mengunduh PDF.</a>
            </div>
        @endif

        <form method="POST" action="{{ route('sirekap.rekomendasi.preview') }}" class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
            @csrf

            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-zinc-800">Daftar Tenaga Kerja</h3>
                    <p class="text-sm text-zinc-500">Centang tenaga kerja yang akan dimasukkan ke rekomendasi.</p>
                </div>
                <div class="flex items-center gap-2">
                    <label for="tanggal" class="text-sm font-medium text-zinc-600">Tanggal rekomendasi</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}"
                        class="rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900">
                </div>
            </div>

            @error('tenaga_kerja_ids')
                <div class="mt-3 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
                    {{ $message }}
                </div>
            @enderror

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 text-sm">
                    <thead>
                        <tr class="bg-zinc-50 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                            <th class="px-3 py-2">
                                <input type="checkbox" id="check-all"
                                    class="h-4 w-4 rounded border-zinc-300 text-slate-900 focus:ring-slate-900">
                            </th>
                            <th class="px-3 py-2">Nama</th>
                            <th class="px-3 py-2">NIK</th>
                            <th class="px-3 py-2">Perusahaan</th>
                            <th class="px-3 py-2">Destinasi</th>
                            <th class="px-3 py-2">Tanggal Lahir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @forelse ($tenagaKerjas as $tenagaKerja)
                            <tr class="hover:bg-zinc-50">
                                <td class="px-3 py-2">
                                    <input type="checkbox" name="tenaga_kerja_ids[]" value="{{ $tenagaKerja->id }}"
                                        class="h-4 w-4 rounded border-zinc-300 text-slate-900 focus:ring-slate-900">
                                </td>
                                <td class="px-3 py-2 font-semibold text-zinc-800">
                                    {{ $tenagaKerja->nama }}
                                </td>
                                <td class="px-3 py-2 text-zinc-700">
                                    {{ $tenagaKerja->nik }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $tenagaKerja->perusahaan->nama ?? '-' }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $tenagaKerja->negara->nama ?? '-' }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ optional($tenagaKerja->tanggal_lahir)->translatedFormat('d F Y') ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-6 text-center text-zinc-500">
                                    Tidak ada data tenaga kerja yang tersedia untuk dibuat rekomendasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex flex-col gap-3 border-t border-zinc-100 pt-4 md:flex-row md:items-center md:justify-between">
                {{ $tenagaKerjas->links() }}

                <button type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-2 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:bg-zinc-400"
                    id="preview-button">
                    Preview Rekomendasi
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkAll = document.getElementById('check-all');
            const checkboxes = document.querySelectorAll('input[name="tenaga_kerja_ids[]"]');
            const previewButton = document.getElementById('preview-button');

            const toggleSubmitState = () => {
                const hasChecked = Array.from(checkboxes).some((checkbox) => checkbox.checked);
                if (previewButton) {
                    previewButton.disabled = !hasChecked;
                }
            };

            if (checkAll) {
                checkAll.addEventListener('change', () => {
                    checkboxes.forEach((checkbox) => {
                        checkbox.checked = checkAll.checked;
                    });
                    toggleSubmitState();
                });
            }

            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', toggleSubmitState);
            });

            toggleSubmitState();
        });
    </script>
@endpush
