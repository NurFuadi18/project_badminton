<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function postLogin(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Jika autentikasi berhasil, redirect ke halaman yang diinginkan
        return redirect()->intended('index');
    }

    // Jika autentikasi gagal, kembali ke halaman login dengan pesan peringatan
    return redirect('login')->withInput()->withErrors(['error' => 'Username atau password salah!']);
}
    public function login()
    {
        return view('login');
    }

    public function gantipassword()
    {
        return view('gantipassword');
    }
}
