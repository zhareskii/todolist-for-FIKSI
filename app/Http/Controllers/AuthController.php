<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

session_start();

class AuthController extends Controller
{

    function tampilRegis(){
        return view('layout.index');
    }

    // Menangani pengiriman data registrasi
    public function submitRegis(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Menyimpan pengguna baru
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    // Login otomatis setelah registrasi

    return redirect()->route('layout.home');
}


    // Menampilkan form login
    function tampilLogin()
    {
        return view('layout.index'); // Ganti dengan view yang sesuai
    }

    // Menangani pengiriman data login
    function submitLogin(Request $request)
    {
        $data = $request->only('name', 'password');

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            // Redirect ke halaman beranda setelah login
            return redirect()->route('layout.home'); // Arahkan ke halaman beranda
        } else {
            return redirect()->back()->with('gagal', 'Email atau password anda salah!');
        }
    }

}

