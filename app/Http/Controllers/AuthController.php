<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Normalisasi email agar validasi domain tidak bergantung pada huruf besar/kecil.
        $request->merge([
            'email' => strtolower(trim((string) $request->email)),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email:rfc',
                'max:255',
                'unique:users,email',
                'regex:/^[^@\\s]+@mhs\\.unimal\\.ac\\.id$/i',
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.regex' => 'Registrasi hanya menggunakan email mahasiswa @mhs.unimal.ac.id.',
            'email.unique' => 'Email tersebut sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pelapor',
            'status' => 'aktif',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('pelapor.dashboard')
            ->with('success', 'Registrasi berhasil. Selamat datang!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
                'regex:/^[^@\s]+@(mhs\.)?unimal\.ac\.id$/',
            ],
            'password' => [
                'required',
            ],
        ], [
            'email.regex' => 'Gunakan email kampus UNIMAL yang valid.',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password salah.',
                ])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        return match (Auth::user()->role) {
            'pelapor' => redirect()->route('pelapor.dashboard'),
            'admin_fakultas' => redirect()->route('admin.fakultas.dashboard'),
            'admin_biro' => redirect()->route('admin.biro.dashboard'),
            default => abort(403),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}