<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            // Memperbarui session setelah login
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')
                ->with('success', 'Berhasil login!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang dimasukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Menghapus session pengguna
        $request->session()->invalidate();

        // Membuat token CSRF baru
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Berhasil logout.');
    }
}


