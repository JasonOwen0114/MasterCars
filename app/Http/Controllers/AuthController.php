<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }

    
    public function loginProses(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (auth()->user()->role == 1) {
                return redirect()->route('admin.dashboard');
            }
            if (auth()->user()->role == 2) {
                return redirect()->route('staff.dashboard');
            }
            return redirect()->route('dashboard');
        }
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    public function register()
    {
        return view('auth.register');
    }

 public function registerProses(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required',
            'password' => 'required|min:6|confirmed'
        ],[
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.',
            'email.required' => 'Email wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 3
        ]);

        return redirect()->route('login')
            ->with('success','Registrasi berhasil, silakan login');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
