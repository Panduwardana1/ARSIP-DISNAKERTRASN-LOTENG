<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Anda perlu login untuk mengelola profil.');
        }

        return view('layouts.profile', compact('user'));
    }

    public function edit(string $id)
    {
        $user = Auth::user();

        if (!$user || (int) $id !== (int) $user?->id) {
            abort(403, 'Anda tidak dapat mengubah profil pengguna lain.');
        }

        return view('layouts.profile-edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = $request->user();

        if (!$user || (int) $id !== (int) $user?->id) {
            abort(403, 'Anda tidak dapat mengubah profil pengguna lain.');
        }

        $canChangePassword = $user->can('manage_users');

        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'nip' => ['required', 'digits:18', Rule::unique('users', 'nip')->ignore($user->id)],
            'password' => $canChangePassword ? ['nullable', 'string', 'min:6', 'confirmed'] : ['prohibited'],
            'gambar' => ['nullable', 'image', 'max:2048'],
        ];

        $validated = $request->validate($rules);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'nip' => $validated['nip'],
        ]);

        if ($canChangePassword && !empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('profiles', 'public');

            if ($user->gambar && Storage::disk('public')->exists($user->gambar)) {
                Storage::disk('public')->delete($user->gambar);
            }

            $user->gambar = $path;
        }

        $user->save();

        return redirect()
            ->route('sirekap.user.profile.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
