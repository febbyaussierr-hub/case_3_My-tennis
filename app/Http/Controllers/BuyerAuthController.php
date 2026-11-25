<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerAuthController extends Controller
{
    // Menampilkan halaman register buyer
    public function showRegister()
    {
        return view('auth.buyer-register');
    }

    // Proses register buyer
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before_or_equal:today',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'password' => $validated['password'],
            'role' => 'buyer',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/');
    }

    // Menampilkan halaman login buyer
    public function showLogin()
    {
        return view('auth.buyer-login');
    }

    // Proses login buyer
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials['role'] = 'buyer';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password BUYER salah.',
        ])->onlyInput('email');
    }

    // Logout buyer
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
