@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | P3MI')
@section('titlePageContent', 'Data P3MI')
@section('description', 'Kelola data perusahaan penempatan Pekerja Migran Indonesia.')

@section('headerAction')
    <div class="flex flex-col sm:flex-row gap-3 items-center justify-between w-full">
        {{-- Search Bar --}}
        <form method="GET" action="{{ route('sirekap.perusahaan.index') }}"
            class="relative w-full sm:max-w-xs font-inter group">
            <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400 group-focus-within:text-blue-600">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </span>
            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama perusahaan"
                class="w-full pl-10 py-2 rounded-lg border border-zinc-200 bg-white text-zinc-700 placeholder-zinc-400 transition-all duration-200 outline-none text-sm" />
        </form>

        {{-- Action Button --}}
        <div class="w-full sm:w-auto" x-data>
            <button type="button" @click="$dispatch('perusahaan-modal:create')"
                class="flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-all shadow-sm w-full sm:w-auto">
                <x-heroicon-o-plus class="w-5 h-5" />
                Tambah
            </button>
        </div>
    </div>
@endsection

@section('content')
    @php
        $oldFormData = [
            'mode' => old('form_mode'),
            'id' => old('perusahaan_id'),
            'nama' => old('nama'),
            'pimpinan' => old('pimpinan'),
            'email' => old('email'),
            'alamat' => old('alamat'),
        ];

        $modalPerusahaans = $perusahaans
            ->map(function ($perusahaan) {
                return [
                    'id' => $perusahaan->id,
                    'nama' => $perusahaan->nama,
                    'pimpinan' => $perusahaan->pimpinan,
                    'email' => $perusahaan->email,
                    'alamat' => $perusahaan->alamat,
                    'gambar_url' => $perusahaan->gambar ? asset('storage/' . ltrim($perusahaan->gambar, '/')) : null,
                ];
            })
            ->values();
    @endphp

    <div x-data="perusahaanModal({ items: @js($modalPerusahaans), oldForm: @js($oldFormData) })" x-init="init()" x-on:perusahaan-modal:create.window="openCreate()"
        class="space-y-4">
        {{-- Error Alert --}}
        @if ($errors->has('message'))
            <div
                class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 flex items-center gap-2">
                <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                {{ $errors->first('message') }}
            </div>
        @endif

        {{-- Main Table Card --}}
        <div class="bg-white border border-zinc-200 rounded-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-zinc-600 border-b border-zinc-200">
                        <tr>
                            <th class="p-4 w-10">
                                <p class="text-xs font-semibold text-zinc-100 uppercase tracking-wider text-center">No</p>
                            </th>
                            <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                P3MI
                            </th>
                            <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                Alamat
                            </th>
                            <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                Dibuat
                            </th>
                            <th class="py-4 px-4 text-end text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @forelse ($perusahaans as $items)
                            <tr class="group hover:bg-zinc-50/80 transition-colors duration-200">
                                {{-- Number --}}
                                <td class="p-4 align-middle text-center">
                                    <span class="text-sm text-zinc-500">
                                        {{ ($perusahaans->currentPage() - 1) * $perusahaans->perPage() + $loop->iteration }}
                                    </span>
                                </td>

                                {{-- P3MI --}}
                                <td class="p-4 align-middle">
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('sirekap.perusahaan.show', $items) }}" class="flex items-center">
                                            @php
                                                $imagePath = $items->gambar
                                                    ? 'storage/' . ltrim($items->gambar, '/')
                                                    : null;
                                            @endphp

                                            @if ($imagePath && file_exists(public_path($imagePath)))
                                                <img src="{{ asset($imagePath) }}" alt="Logo {{ $items->nama }}"
                                                    class="h-9 w-9 rounded-full object-cover">
                                            @else
                                                <x-heroicon-o-building-office class="h-9 w-9 text-zinc-400" />
                                            @endif
                                        </a>
                                        <div class="grid space-y-0">
                                            <p class="text-sm font-semibold text-zinc-900">{{ $items->nama }}</p>
                                            <p class="text-xs font-medium text-zinc-600">{{ $items->pimpinan }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Email --}}
                                <td class="p-4 align-middle">
                                    <p class="text-sm text-zinc-900">
                                        {{ $items->email ?? '-' }}
                                    </p>
                                </td>

                                {{-- Alamat --}}
                                <td class="p-4 align-middle">
                                    <p class="text-sm text-zinc-900" title="{{ $items->alamat }}">
                                        {{ Str::limit($items->alamat, 40) ?? '-' }}
                                    </p>
                                </td>

                                {{-- Date --}}
                                <td class="p-4 align-middle">
                                    <p class="text-sm text-zinc-500">
                                        {{ optional($items->created_at)->translatedFormat('d F Y') }}
                                    </p>
                                </td>

                                {{-- Actions --}}
                                <td class="p-4 align-middle text-end">
                                    <div class="flex items-center justify-end gap-2">
                                        @php
                                            $payload = [
                                                'id' => $items->id,
                                                'nama' => $items->nama,
                                                'pimpinan' => $items->pimpinan,
                                                'email' => $items->email,
                                                'alamat' => $items->alamat,
                                                'gambar_url' => $items->gambar
                                                    ? asset('storage/' . ltrim($items->gambar, '/'))
                                                    : null,
                                            ];
                                        @endphp
                                        <button type="button" @click="openEdit(@js($payload))"
                                            class="p-1.5 text-zinc-500 hover:text-amber-700 transition-colors"
                                            title="Edit">
                                            <x-heroicon-o-pencil class="w-5 h-5" />
                                        </button>

                                        <x-modal-delete :action="route('sirekap.perusahaan.destroy', $items)" :title="'Hapus Data'" :message="'Data ' . $items->nama . ' akan dihapus permanen.'"
                                            confirm-field="confirm_delete">
                                            <button type="button"
                                                class="p-1.5 text-zinc-500 hover:text-rose-600 transition-colors"
                                                title="Hapus">
                                                <x-heroicon-o-trash class="h-5 w-5" />
                                            </button>
                                        </x-modal-delete>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-zinc-500">
                                        <x-heroicon-o-building-office class="w-12 h-12 text-zinc-300 mb-3" />
                                        <p class="text-base font-medium">Belum ada data P3MI</p>
                                        <p class="text-sm">Silakan tambahkan data baru untuk memulai.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Pagination --}}
            @if ($perusahaans->hasPages())
                <div class="border-t border-zinc-200 bg-zinc-50 px-4 py-3 sm:px-6">
                    {{ $perusahaans->onEachSide(2)->links() }}
                </div>
            @endif
        </div>

        {{-- Modal Create/Update --}}
        <div x-cloak x-show="open" x-transition.opacity.duration.200ms x-on:keydown.escape.window="close()"
            class="fixed inset-0 z-30 flex items-center justify-center bg-zinc-200/50 px-4 py-6">
            <div x-show="open" x-transition.scale.duration.200ms
                class="w-full max-w-3xl rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
                <div class="flex items-start justify-between border-b px-5 py-4">
                    <div class="space-y-0.5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600"
                            x-text="mode === 'create' ? 'Tambah' : 'Perbarui'"></p>
                        <h2 class="text-lg font-semibold text-zinc-900"
                            x-text="mode === 'create' ? 'Tambah Data P3MI' : 'Ubah Data P3MI'"></h2>
                        <p class="text-sm text-zinc-500">Kelola data perusahaan penempatan langsung di halaman ini.</p>
                    </div>
                    <button type="button" @click="close()"
                        class="rounded-full bg-zinc-100 p-2 text-zinc-500 transition hover:text-zinc-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        aria-label="Tutup">
                    <x-heroicon-o-x-mark class="h-5 w-5" />
                </button>
            </div>

                <form :action="formAction" method="POST" enctype="multipart/form-data" class="space-y-5 p-5">
                    @csrf
                    <template x-if="mode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <input type="hidden" name="form_mode" :value="mode">
                    <input type="hidden" name="perusahaan_id" :value="form.id">

                    @if ($errors->has('message'))
                        <div
                            class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 flex items-center gap-2">
                            <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                            {{ $errors->first('message') }}
                        </div>
                    @endif

                    <div class="space-y-6">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-zinc-700">
                                Nama Perusahaan <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama" x-model="form.nama" maxlength="100"
                                required
                                class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-emerald-400">
                            @error('nama')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="pimpinan" class="block text-sm font-medium text-zinc-700">
                                    Nama Pimpinan
                                </label>
                                <input type="text" id="pimpinan" name="pimpinan" x-model="form.pimpinan"
                                    maxlength="100"
                                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-emerald-400">
                                @error('pimpinan')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-zinc-700">
                                    Email Perusahaan
                                </label>
                                <input type="email" id="email" name="email" x-model="form.email"
                                    maxlength="100"
                                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-emerald-400">
                                @error('email')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="alamat" class="block text-sm font-medium text-zinc-700">
                                Alamat Operasional
                            </label>
                            <textarea id="alamat" name="alamat" rows="4" x-model="form.alamat"
                                class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-emerald-400"></textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="gambar" class="block text-sm font-medium text-zinc-700">
                                Logo/Identitas Visual
                            </label>
                            <input type="file" id="gambar" name="gambar" accept=".png,.jpg,.jpeg" x-ref="gambar"
                                class="w-full rounded-md border border-dashed border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-emerald-400">
                            <p class="text-xs text-zinc-500">PNG/JPG/JPEG maks. 2 MB (opsional).</p>
                            @error('gambar')
                                <p class="text-sm text-rose-600">{{ $message }}</p>
                            @enderror

                            <div class="flex items-center gap-3 rounded-md border border-zinc-200 bg-zinc-50 p-3 text-sm text-zinc-700"
                                x-show="mode === 'edit' && form.gambar_url">
                                <x-heroicon-o-photo class="h-5 w-5 text-indigo-500" />
                                <span class="truncate" x-text="form.gambar_url"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-zinc-100">
                        <button type="button" @click="close()"
                            class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                            <span x-text="mode === 'create' ? 'Simpan' : 'Update'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function perusahaanModal(config) {
            return {
                open: false,
                mode: 'create',
                form: {
                    id: null,
                    nama: '',
                    pimpinan: '',
                    email: '',
                    alamat: '',
                    gambar_url: null,
                },
                items: config?.items || [],
                oldForm: config?.oldForm || {},
                updateBase: '{{ url('/sirekap/perusahaan') }}',
                get formAction() {
                    return this.mode === 'create' ?
                        '{{ route('sirekap.perusahaan.store') }}' :
                        `${this.updateBase}/${this.form.id}`;
                },
                openCreate() {
                    this.mode = 'create';
                    this.resetForm();
                    this.open = true;
                },
                openEdit(item) {
                    this.mode = 'edit';
                    this.resetForm();
                    this.form = {
                        ...this.form,
                        ...item
                    };
                    this.open = true;
                },
                close() {
                    this.open = false;
                    this.resetForm();
                },
                resetForm() {
                    this.form = {
                        id: null,
                        nama: '',
                        pimpinan: '',
                        email: '',
                        alamat: '',
                        gambar_url: null,
                    };
                    if (this.$refs.gambar) {
                        this.$refs.gambar.value = '';
                    }
                },
                init() {
                    if (this.oldForm?.mode === 'create') {
                        this.mode = 'create';
                        this.form = {
                            ...this.form,
                            ...this.oldForm
                        };
                        this.open = true;
                    }

                    if (this.oldForm?.mode === 'edit' && this.oldForm?.id) {
                        const fallback = this.items.find((item) => String(item.id) === String(this.oldForm.id)) || {
                            id: this.oldForm.id
                        };
                        this.mode = 'edit';
                        this.form = {
                            ...this.form,
                            ...fallback,
                            ...this.oldForm
                        };
                        this.open = true;
                    }
                },
            };
        }
    </script>
@endpush
