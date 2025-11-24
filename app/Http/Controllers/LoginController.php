<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function login(Request $request) {
        return view("auth.login");
    }

    public function createAuth(LoginRequest $request) {
        $identifier = $request->input('identifier');

        $key = 'login-attempt:' . Str::lower($identifier);

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'identifier' => 'Terlalu banyak percobaan login. Coba lagi dalam 1 menit.'
            ]);
        }

        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';
        $credentials = [
            $field => $identifier,
            'password' => $request->input('password'),
        ];

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($key, 60);
            return back()->withErrors([
                'identifier' => 'NIP/Email atau password salah.',
            ]);
        }

        RateLimiter::clear($key);

        $user = Auth::user();

        $isActive = $user && in_array($user->is_active, ['active', 1, '1', true], true);

        if (!$isActive) {
            Auth::logout();
            return back()->withErrors([
                'identifier' => 'Akun Anda dinonaktifkan. Hubungi admin.',
            ]);
        }

        $request->session()->regenerate();

        $home = $user->can('view_dashboard')
            ? route('sirekap.dashboard.index')
            : route('sirekap.tenaga-kerja.index');

        if (!$user->can('view_dashboard')) {
            return redirect()->to($home);
        }

        return redirect()->intended($home);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
}
