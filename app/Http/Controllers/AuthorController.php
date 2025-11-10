<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthorController extends Controller
{
    public function index(): View
    {
        $authors = Author::query()
            ->select('id', 'nama', 'nip', 'jabatan', 'created_at')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('cruds.author.index', compact('authors'));
    }

    public function create(): View
    {
        return view('cruds.author.create');
    }

    public function store(AuthorRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            Author::create($data);
        } catch (Throwable $e) {
            Log::error('Gagal menambahkan author.', ['exception' => $e]);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Terjadi kesalahan saat menambahkan author.']);
        }

        return redirect()
            ->route('sirekap.author.index')
            ->with('success', 'Author berhasil ditambahkan.');
    }

    public function edit(Author $author): View
    {
        return view('cruds.author.edit', compact('author'));
    }

    public function update(AuthorRequest $request, Author $author): RedirectResponse
    {
        $data = $request->validated();

        try {
            $author->update($data);
        } catch (Throwable $e) {
            Log::error('Gagal memperbarui author.', [
                'exception' => $e,
                'author_id' => $author->id,
            ]);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Terjadi kesalahan saat memperbarui author.']);
        }

        return redirect()
            ->route('sirekap.author.index')
            ->with('success', 'Author berhasil diperbarui.');
    }

    public function destroy(Author $author): RedirectResponse
    {
        try {
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
            ->with('success', 'Author berhasil dihapus.');
    }
}
