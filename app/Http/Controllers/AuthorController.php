<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class AuthorController extends Controller
{
    public function index(): View
    {
        $search = trim((string) request('q', ''));

        $authors = Author::query()
            ->select('id', 'nama', 'nip', 'jabatan', 'avatar', 'created_at')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder
                        ->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('nip', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('cruds.author.index', compact('authors', 'search'));
    }

    public function create(): View
    {
        return view('cruds.author.create');
    }

    public function store(AuthorRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $data['avatar'] = $file->storeAs('authors', $fileName, 'public');
            }

            Author::create($data);
        } catch (Throwable $e) {
            Log::error('Gagal menambahkan data pimpinan.',
            [
                'exception' => $e,
                'message' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Terjadi kesalahan saat menambahkan author.']);
        }

        return redirect()
            ->route('sirekap.author.index')
            ->with('success', 'Pimpinan berhasil ditambahkan.');
    }

    public function edit(Author $author): View
    {
        return view('cruds.author.edit', compact('author'));
    }

    public function update(AuthorRequest $request, Author $author): RedirectResponse
    {
        $data = $request->validated();

        try {
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $data['avatar'] = $file->storeAs('authors', $fileName, 'public');

                if ($author->avatar && Storage::disk('public')->exists($author->avatar)) {
                    Storage::disk('public')->delete($author->avatar);
                }
            }

            $author->update($data);
        } catch (Throwable $e) {
            Log::error('Gagal memperbarui data.', [
                'exception' => $e,
                'author_id' => $author->id,
            ]);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Terjadi kesalahan saat memperbarui data.']);
        }

        return redirect()
            ->route('sirekap.author.index')
            ->with('success', 'Pimpian berhasil diperbarui.');
    }

    public function destroy(Author $author): RedirectResponse
    {
        try {
            if ($author->avatar && Storage::disk('public')->exists($author->avatar)) {
                Storage::disk('public')->delete($author->avatar);
            }
            $author->delete();
        } catch (Throwable $e) {
            Log::error('Gagal menghapus author.', [
                'exception' => $e,
                'author_id' => $author->id,
            ]);

            return back()->withErrors(['app' => 'Terjadi kesalahan saat menghapus author.']);
        }

        return redirect()
            ->route('sirekap.author.index')
            ->with('success', 'Pimpinan berhasil dihapus.');
    }
}
