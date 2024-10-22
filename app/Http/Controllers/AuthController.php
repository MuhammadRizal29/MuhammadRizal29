<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');
        $guards = ['admin', 'guru', 'orangtua'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->attempt($credentials)) {
                $request->session()->regenerate();
                return $this->redirectBasedOnGuard($guard);
            }
        }

        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        $guards = ['admin', 'guru', 'orangtua'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
                break;
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectBasedOnGuard($guard)
    {
        return redirect()->intended($this->redirectTo($guard));
    }

    protected function redirectTo($guard)
    {
        $redirects = [
            'admin' => '/admin/dashboard',
            'guru' => '/guru/dashboard',
            'orangtua' => '/orangtua/dashboard',
        ];

        return $redirects[$guard] ?? '/';
    }
}