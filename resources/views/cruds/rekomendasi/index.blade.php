@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Rekomendasi')
@section('titlePageContent', 'Rekomendasi Tenaga Kerja')
@section('description', 'Pilih PMI yang akan disertakan dalam surat rekomendasi.')



{{-- HEADER ACTION: SEARCH + BUTTON PREVIEW --}}
@section('headerAction')
    <div class="flex flex-col sm:flex-row gap-3 items-center justify-between w-full">
        {{-- FORM SEARCH (GET) --}}
        <form method="GET" action="{{ route('sirekap.rekomendasi.index') }}"
            class="relative w-full sm:max-w-xs font-inter group">
            <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400 group-focus-within:text-blue-600">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </span>

            <input type="search" name="search" placeholder="Cari nama atau NIK" value="{{ request('search') }}"
                class="w-full pl-10 py-2 rounded-lg border border-zinc-200 bg-white text-zinc-700 placeholder-zinc-400 transition-all duration-200 outline-none text-sm" />
        </form>

        {{-- TOMBOL PREVIEW (SUBMIT FORM POST DI BAWAH) --}}
        <div class="flex gap-2 w-full sm:w-auto justify-end">
            <a href="{{ route('sirekap.rekomendasi.data') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-zinc-200 text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition-all shadow-sm">
                <x-heroicon-o-document-text class="w-5 h-5" />
                Data
            </a>
            <button type="submit" form="rekomendasi-form"
                class="flex items-center justify-center gap-2 px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-medium hover:bg-amber-700 transition-all shadow-sm">
                <x-heroicon-o-eye class="w-5 h-5" />
                Preview
            </button>
        </div>
    </div>
@endsection

@section('content')

    @error('selected_ids')
        <div class="mb-4 rounded-md border border-rose-200 bg-rose-50 px-5 py-3 text-sm text-rose-700">
            {{ $message }}
        </div>
    @enderror

    {{-- WRAPPER ALPINE UNTUK SELEKSI --}}
    <div x-data="{
        // array object { id, nama, nik }
        selected: JSON.parse(localStorage.getItem('rekomendasi_selected') || '[]'),

        // data di halaman saat ini
        pageItems: {{ $tenagaKerjas->getCollection()->map(fn($tk) => ['id' => $tk->id, 'nama' => $tk->nama, 'nik' => $tk->nik])->values()->toJson() }},
        pageIds: {{ $tenagaKerjas->getCollection()->pluck('id')->toJson() }},

        master: false,

        get selectedIds() {
            return this.selected.map(item => item.id);
        },

        init() {
            this.master = this.pageIds.length > 0 &&
                this.pageIds.every(id => this.selectedIds.includes(id));
        },

        save() {
            localStorage.setItem('rekomendasi_selected', JSON.stringify(this.selected));
        },

        toggle(id, nama, nik) {
            id = Number(id);

            if (this.selectedIds.includes(id)) {
                this.selected = this.selected.filter(item => item.id !== id);
            } else {
                this.selected.push({ id, nama, nik });
            }

            this.master = this.pageIds.length > 0 &&
                this.pageIds.every(pid => this.selectedIds.includes(pid));

            this.save();
        },

        toggleAllOnPage() {
            const allSelected = this.pageIds.length > 0 &&
                this.pageIds.every(id => this.selectedIds.includes(id));

            if (allSelected) {
                // hilangkan semua id halaman ini dari selected
                this.selected = this.selected.filter(item => !this.pageIds.includes(item.id));
                this.master = false;
            } else {
                // tambahkan semua item halaman ini ke selected
                this.pageItems.forEach(item => {
                    if (!this.selectedIds.includes(item.id)) {
                        this.selected.push(item);
                    }
                });
                this.master = true;
            }

            this.save();
        },

        isSelected(id) {
            return this.selectedIds.includes(Number(id));
        },

        remove(id) {
            id = Number(id);
            this.selected = this.selected.filter(item => item.id !== id);
            this.master = this.pageIds.length > 0 &&
                this.pageIds.every(pid => this.selectedIds.includes(pid));
            this.save();
        },

        clearAll() {
            this.selected = [];
            this.master = false;
            this.save();
        }
    }" x-init="init()" class="space-y-4">

        {{-- FORM PREVIEW (POST) --}}
        <form id="rekomendasi-form" method="POST" action="{{ route('sirekap.rekomendasi.preview') }}">
            @csrf

            <div class="bg-white border border-zinc-200 rounded-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-zinc-600 border-b border-zinc-200">
                            <tr>
                                <th class="p-4 w-12">
                                    <span class="sr-only">Pilih semua</span>
                                    <input type="checkbox" :checked="master" @click.prevent="toggleAllOnPage()"
                                        class="rounded border-blue-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                    Identitas
                                </th>
                                <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                    P3MI
                                </th>
                                <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                    Agency
                                </th>
                                <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                    Pekerjaan
                                </th>
                                <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                    Destinasi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-zinc-100">
                            @forelse ($tenagaKerjas as $tk)
                                <tr class="group hover:bg-zinc-50/80 transition-colors duration-200">
                                    <td class="p-4 align-middle">
                                        <input type="checkbox"
                                            @change="toggle({{ $tk->id }}, @js($tk->nama), @js($tk->nik))"
                                            :checked="isSelected({{ $tk->id }})"
                                            class="rounded border-blue-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('asset/images/default-profile.jpg') }}" alt="Profile"
                                                class="h-12 w-12 rounded-full border border-zinc-200 object-cover">
                                            <span class="grid items-center">
                                                <p class="text-sm font-semibold text-zinc-900">{{ $tk->nama }}</p>
                                                <p class="text-xs font-medium text-zinc-600">{{ $tk->nik }}</p>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <p class="text-sm text-zinc-900">{{ $tk->perusahaan->nama ?? '-' }}</p>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <p class="text-sm text-zinc-900">{{ $tk->agency->nama ?? '-' }}</p>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <p class="text-sm text-zinc-900">{{ $tk->agency->lowongan ?? '-' }}</p>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <p class="text-sm text-zinc-900">{{ $tk->negara->nama ?? '-' }}</p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-zinc-500">
                                            <x-heroicon-o-document-text class="w-12 h-12 text-zinc-300 mb-3" />
                                            <p class="text-base font-medium">Belum ada data PMI</p>
                                            <p class="text-sm">Tambah data tenaga kerja untuk direkomendasikan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Footer Pagination --}}
                @if ($tenagaKerjas->hasPages())
                    <div class="border-t border-zinc-200 bg-zinc-50 px-4 py-3 sm:px-6">
                        {{ $tenagaKerjas->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>

            {{-- HIDDEN INPUT UNTUK DIKIRIM KE CONTROLLER --}}
            <template x-for="item in selected" :key="item.id">
                <input type="hidden" name="selected_ids[]" :value="item.id">
            </template>
        </form>

        <div class="mt-2 rounded-lg border p-4" x-show="selected.length" x-transition>
            <div class="flex items-center justify-between gap-2">
                <p class="text-sm font-semibold">
                    Terpilih: <span x-text="selected.length"></span>
                </p>
                <button type="button" @click="clearAll()" class="text-xs text-amber-700 ">
                    Bersihkan semua
                </button>
            </div>

            <ul class="mt-3 space-y-1 max-h-40 overflow-y-auto text-sm text-amber-900">
                <template x-for="item in selected" :key="item.id">
                    <li class="flex items-center justify-between gap-2">
                        <span>
                            <span class="font-medium" x-text="item.nama"></span>
                            <span class="ml-1 text-xs text-amber-800" x-text="'(' + item.nik + ')'"></span>
                        </span>
                        <button type="button" @click="remove(item.id)" class="text-xs text-amber-700 hover:underline">
                            Hapus
                        </button>
                    </li>
                </template>
            </ul>
        </div>

    </div>
@endsection
