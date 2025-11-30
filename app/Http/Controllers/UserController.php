<?php

namespace App\Http\Controllers;

use App\Models\User;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:manage_users']);
    }

    public function index(Request $request): View
    {
        $search = (string) $request->input('q', '');

        $users = User::query()
            ->with('roles:id,name')
            ->when(
                $search !== '',
                fn ($query) => $query->where(function ($builder) use ($search) {
                    $builder->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('nip', 'like', '%' . $search . '%');
                })
            )
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $roles = Role::query()->orderBy('name')->pluck('name');

        return view('cruds.users.index', [
            'users' => $users,
            'search' => $search,
            'roles' => $roles,
        ]);
    }

    public function create(): View
    {
        $roles = Role::query()->orderBy('name')->pluck('name');

        return view('cruds.users.create', [
            'roles' => $roles,
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'nip' => $data['nip'],
                'password' => $data['password'],
                'is_active' => $data['is_active'],
            ]);

            $user->syncRoles([$data['role']]);

            return redirect()
                ->route('sirekap.users.index')
                ->with('success', 'User berhasil dibuat.');
        } catch (Throwable $t) {
            report($t);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Gagal membuat user. Silakan coba lagi.']);
        }
    }

    public function edit(User $user): View
    {
        $roles = Role::query()->orderBy('name')->pluck('name');
        $user->load('roles:id,name');

        return view('cruds.users.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $isSelfUpdate = (int) $request->user()->id === (int) $user->id;

        if ($isSelfUpdate && $data['is_active'] !== 'active') {
            return back()
                ->withInput()
                ->withErrors(['is_active' => 'Anda tidak dapat menonaktifkan akun sendiri.']);
        }

        try {
            $user->fill([
                'name' => $data['name'],
                'email' => $data['email'],
                'nip' => $data['nip'],
                'is_active' => $data['is_active'],
            ]);

            if (!empty($data['password'])) {
                $user->password = $data['password'];
            }

            $user->save();
            $user->syncRoles([$data['role']]);

            return redirect()
                ->route('sirekap.users.index')
                ->with('success', 'User berhasil diperbarui.');
        } catch (Throwable $t) {
            report($t);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Gagal memperbarui user. Silakan coba lagi.']);
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        if ((int) auth()->id() === (int) $user->id) {
            return back()->withErrors(['app' => 'Anda tidak dapat menghapus akun sendiri.']);
        }

        try {
            $user->delete();

            return redirect()
                ->route('sirekap.users.index')
                ->with('success', 'User berhasil dihapus.');
        } catch (Throwable $t) {
            report($t);

            return back()->withErrors(['app' => 'Gagal menghapus user.']);
        }
    }
}
