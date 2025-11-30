@extends('layouts.app')

@section('titlePageContent', 'Log Aktivitas')
@section('description', 'Pantau perubahan yang dilakukan admin dan staf. Hanya admin yang dapat mengelola riwayat ini.')

@section('headerAction')
    <form action="{{ route('sirekap.logs.clear') }}" method="POST"
        onsubmit="return confirm('Bersihkan seluruh log aktivitas?')">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="inline-flex items-center gap-2 rounded-md border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">
            <x-heroicon-o-trash class="h-4 w-4" />
            Bersihkan Semua
        </button>
    </form>
@endsection

@section('content')
    <div class="space-y-4">
        <div class="rounded-md border border-zinc-200 bg-white">
            <form method="GET" class="flex flex-col gap-3 p-4 lg:flex-row lg:items-end lg:justify-between lg:flex-wrap">
                <div class="flex flex-wrap gap-3">
                    <div class="space-y-1 w-full sm:w-56">
                        <select name="role"
                            class="w-full rounded-md border border-zinc-200 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua</option>
                            @foreach (['admin', 'staf'] as $role)
                                <option value="{{ $role }}" @selected(($filters['role'] ?? '') === $role)>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1">
                        <div class="inline-flex overflow-hidden rounded-md border border-zinc-200 bg-zinc-50">
                            <label
                                class="flex cursor-pointer items-center gap-2 px-3 py-2 text-sm font-medium text-zinc-700">
                                <input type="radio" name="order" value="latest" class="text-blue-600 focus:ring-blue-500"
                                    @checked(($filters['order'] ?? 'latest') === 'latest')>
                                Terbaru
                            </label>
                            <label
                                class="flex cursor-pointer items-center gap-2 border-l border-zinc-200 px-3 py-2 text-sm font-medium text-zinc-700">
                                <input type="radio" name="order" value="oldest" class="text-blue-600 focus:ring-blue-500"
                                    @checked(($filters['order'] ?? 'latest') === 'oldest')>
                                Terlama
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('sirekap.logs.index') }}"
                        class="rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
                        Reset
                    </a>

                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-md bg-blue-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                        <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-md border border-zinc-200 bg-white">
            <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-3">
                <div>
                    <p class="text-sm font-semibold text-zinc-800">Log Aktivitas</p>
                    <p class="text-xs text-zinc-500">Menampilkan {{ $activities->total() }} log</p>
                </div>
                @if (session('success'))
                    <div
                        class="rounded-md border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-medium text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full table-fixed divide-y divide-zinc-200">
                    <thead class="bg-zinc-800 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">
                                Waktu</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">
                                Pengguna</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">
                                Aktivitas</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @forelse ($activities as $activity)
                            @php
                                $props = $activity->properties ?? collect();
                                $route = $props['route'] ?? ($props['path'] ?? null);
                                $method = strtoupper($props['method'] ?? ($activity->event ?? ''));
                                $payload = $props['payload'] ?? [];
                                $targetLabel = $route
                                    ? \Illuminate\Support\Str::of($route)
                                        ->after('sirekap.')
                                        ->beforeLast('.')
                                        ->replace('.', ' ')
                                        ->singular()
                                        ->headline()
                                    : 'Aktivitas';
                                $targetValue =
                                    $payload['nama'] ??
                                    ($payload['name'] ?? ($payload['title'] ?? ($payload['kode'] ?? null)));
                                $actionLabels = [
                                    'POST' => 'Membuat',
                                    'PUT' => 'Memperbarui',
                                    'PATCH' => 'Memperbarui',
                                    'DELETE' => 'Menghapus',
                                    'GET' => 'Mengakses',
                                ];
                                $actionText = $actionLabels[$method] ?? 'Mengelola';
                                $subject = trim($targetLabel . ($targetValue ? ' - ' . $targetValue : ''));
                                $summary = $subject
                                    ? trim($actionText . ' ' . $subject)
                                    : $activity->description ?? 'Aktivitas';
                            @endphp
                            <tr class="hover:bg-zinc-50/50">
                                <td class="px-4 py-4 align-top">
                                    <div class="space-y-1">
                                        <p class="text-xs font-medium text-zinc-900">
                                            {{ optional($activity->created_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 align-top">
                                    <div class="space-y-1">
                                        <p class="text-sm font-semibold text-zinc-900">
                                            {{ $activity->causer?->name ?? 'Sistem' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 align-top">
                                    <div class="space-y-1 text-xs text-zinc-700">
                                        <p class="font-semibold text-zinc-900">{{ $summary ?: '-' }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 align-top">
                                    <form action="{{ route('sirekap.logs.destroy', $activity) }}" method="POST"
                                        onsubmit="return confirm('Hapus log ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 rounded-md border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">
                                            <x-heroicon-o-trash class="h-4 w-4" />
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-sm text-zinc-500">
                                    Belum ada aktivitas yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-zinc-100 px-4 py-3">
                {{ $activities->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection
