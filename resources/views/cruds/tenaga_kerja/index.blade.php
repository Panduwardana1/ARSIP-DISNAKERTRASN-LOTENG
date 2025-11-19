@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Tenaga Kerja')

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

@section('content')

    {{-- title page content --}}
@section('titlePageContent', 'Data PMI')

{{-- description title --}}
@section('description', 'Daftar semua data PMI pada sistem sirekap')

{{-- header action (search dan button) --}}
@section('headerAction')
    {{-- search --}}
    <div>
        <form method="GET" action="{{ route('sirekap.tenaga-kerja.index') }}" class="relative w-full max-w-sm font-inter">
            <input type="hidden" name="status" value="{{ $status }}">
            <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </span>

            <input type="search" name="q" placeholder="Cari nama atau NIK..." value="{{ $search ?? '' }}"
                class="w-full pl-10 py-1.5 rounded-md bg-white border border-zinc-300
                text-zinc-700 placeholder-zinc-400 transition-all duration-200 outline-none" />
        </form>
    </div>

    @error('file')
        <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
    @enderror

    {{-- button --}}
    <div class="flex items-center">
        <div x-data="{ open: false }" x-cloak class="p-4">
            <!-- BUTTON -->
            <button @click="open = true"
                class="flex items-center gap-2 px-4 py-1.5 rounded-md border bg-yellow-600 text-white font-medium hover:bg-yellow-800 transition">
                <x-heroicon-o-document-arrow-down class="w-5 h-5" />
                Import
            </button>

            <!-- MODAL BACKDROP -->
            <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40"
                @click="open = false">
            </div>

            <!-- MODAL CONTAINER -->
            <div x-show="open" x-cloak x-transition x-transition.duration.300ms
                class="fixed inset-0 flex items-center justify-center z-50">
                <div @click.stop class="w-full max-w-md bg-white rounded-xl p-6">
                    <h2 class="text-xl font-semibold mb-4 text-center">Upload File</h2>

                    <form>
                        <label class="block mb-3 text-sm font-medium">Pilih File</label>

                        <input type="file"
                            class="w-full border border-zinc-300 rounded-md py-1.5 px-2 cursor-pointer focus:ring-teal-600" />

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="open = false"
                                class="px-4 py-2 rounded-lg bg-zinc-200 hover:bg-zinc-300 transition">
                                Batal
                            </button>

                            <button class="px-4 py-2 rounded-lg bg-green-700 text-white hover:bg-green-800 transition">
                                Upload
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <a href="{{ route('sirekap.tenaga-kerja.create') }}"
            class="flex items-center px-3 gap-2 py-1.5 bg-blue-600 text-white rounded-md border hover:bg-blue-700">
            <x-heroicon-o-plus class="w-5 h-5" />
            Tambah
        </a>
    </div>
@endsection

{{-- todo Tabel data CPMI --}}
<div class="relative flex flex-col w-full h-auto rounded-lg overflow-hidden max-w-full overflow-x-auto border">
    <table class="w-full text-left table-auto min-w-max">
        <thead class="bg-blue-800 uppercase">
            <tr>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-slate-300">
                        ID
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-slate-300">
                        Identitas
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal text-center leading-none text-slate-300">
                        Gender
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-slate-300">
                        P3MI
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-slate-300">
                        Agency
                    </p>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-slate-300">
                        Pekerjaan
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-slate-300">
                        Terdata
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-slate-300">
                        Aksi
                    </p>
                </th>
            </tr>
        </thead>
        @php
            $index = 1;
        @endphp
        <tbody class="border">
            @forelse ($tenagaKerjas as $items)
                <tr class="border-zinc-300 hover:bg-zinc-100 bg-white border-b">
                    <td class="p-4">

                        <p class="text-sm text-center text-zinc-800">
                            {{-- {{ $loop }} --}}
                        </p>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('sirekap.tenaga-kerja.show', $items) }}">
                                <img src="{{ asset('asset/images/default-profile.jpg') }}" alt="Profile"
                                    class="h-12 w-auto rounded-full border-[1.5px] hover:border-amber-500">
                            </a>
                            <span class="grid items-center">
                                <p class="text-[16px] font-semibold text-zinc-800">{{ $items->nama }}</p>
                                <p class="text-xs font-medium text-zinc-600">{{ $items->nik }}</p>
                            </span>
                        </div>
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-center text-zinc-800">
                            {{ $items->gender }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="text-sm font-medium text-zinc-800">
                            {{ $items->perusahaan->nama ?? 'none' }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="text-sm font-medium text-zinc-800">
                            {{ $items->agency->nama ?? 'none' }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="text-sm font-medium text-zinc-800">
                            {{ $items->agency->lowongan ?? 'none' }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-zinc-800">
                            {{ $items->created_at->translatedFormat('d F Y') }}
                        </p>
                    </td>
                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                        <div class="flex items-center gap-x-6">
                            <a href="{{ route('sirekap.tenaga-kerja.edit', $items) }}"
                                class="text-zinc-600 transition-colors duration-200 hover:text-amber-500">
                                <span class="sr-only">Edit</span>
                                <x-heroicon-o-pencil class="w-5 h-5" />
                            </a>

                            <x-modal-delete :action="route('sirekap.tenaga-kerja.destroy', $items)" :title="'Hapus Data '" :message="'Datas ' . $items->nama . ' akan dihapus permanen.'"
                                confirm-field="confirm_delete">
                                <button type="button" class="text-zinc-600 hover:text-rose-600">
                                    <x-heroicon-o-trash class="h-5 w-5" />
                                </button>
                            </x-modal-delete>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-sm text-zinc-500">
                        <span class="text-zinc-600">Belum ada data / Data tidak ditemukan</span>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ? pagination --}}
<div class="pt-6">
    {{ $tenagaKerjas->onEachSide(2)->links() }}
</div>
@endsection

@push('scripts')
{{-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const kecamatanSelect = document.querySelector('[data-export-kecamatan]');
        const desaSelect = document.querySelector('[data-export-desa]');

        if (!kecamatanSelect || !desaSelect) {
            return;
        }

        const placeholder = desaSelect.querySelector('option[value=""]');
        const desaOptions = Array.from(desaSelect.options).filter((option) => option.value !== '');

        const refreshDesaOptions = (kecamatanId) => {
            const hasKecamatan = Boolean(kecamatanId);
            let hasMatch = false;

            desaSelect.disabled = !hasKecamatan;

            desaOptions.forEach((option) => {
                const match =
                    hasKecamatan &&
                    String(option.dataset.kecamatan) === String(kecamatanId);

                option.hidden = !match;
                option.disabled = !match;

                if (!match && option.selected) {
                    option.selected = false;
                }

                if (match) {
                    hasMatch = true;
                }
            });

            if (!hasMatch && placeholder) {
                placeholder.selected = true;
            }
        };

        refreshDesaOptions(kecamatanSelect.value);

        kecamatanSelect.addEventListener('change', () => {
            refreshDesaOptions(kecamatanSelect.value);
        });
    });
</script> --}}
@endpush
