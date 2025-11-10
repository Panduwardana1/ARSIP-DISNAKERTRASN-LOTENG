@extends('layouts.app')

@section('pageTitle', 'SIREKAP - Author')
@section('Title', 'Author')

@section('content')
    <div class="space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900">Daftar Author</h2>
                <p class="text-sm text-zinc-500">Kelola pejabat yang berwenang menandatangani rekomendasi.</p>
            </div>
            <a href="{{ route('sirekap.author.create') }}"
                class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                + Tambah Author
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl border border-zinc-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-zinc-200 text-sm">
                <thead class="bg-zinc-50 text-xs font-semibold uppercase tracking-wide text-zinc-500">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">NIP</th>
                        <th class="px-4 py-3 text-left">Jabatan</th>
                        <th class="px-4 py-3 text-left">Dibuat</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($authors as $author)
                        <tr>
                            <td class="px-4 py-3 font-semibold text-zinc-900">
                                {{ $author->nama }}
                            </td>
                            <td class="px-4 py-3 font-mono text-sm text-zinc-700">
                                {{ $author->nip }}
                            </td>
                            <td class="px-4 py-3 text-zinc-700">
                                {{ $author->jabatan }}
                            </td>
                            <td class="px-4 py-3 text-zinc-500">
                                {{ $author->created_at?->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('sirekap.author.edit', $author) }}"
                                        class="text-sm font-semibold text-slate-900 hover:underline">
                                        Edit
                                    </a>
                                    <form action="{{ route('sirekap.author.destroy', $author) }}" method="POST"
                                        onsubmit="return confirm('Hapus author ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-sm font-semibold text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-zinc-500">
                                Belum ada data author. Tambahkan data baru melalui tombol "Tambah Author".
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $authors->links() }}
        </div>
    </div>
@endsection
