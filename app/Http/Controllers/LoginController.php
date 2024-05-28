<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\pelanggan;

class LoginController extends Controller
{
    public function loginpelanggan(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $pelanggan = pelanggan::where('email', $request->email)->first();

        // Cek apakah pengguna ada dan password sesuai
        if ($pelanggan && Hash::check($request->password, $pelanggan->password)) {
            $accessToken = $pelanggan->createToken('authToken')->plainTextToken;

            return response()->json(['access_token' => $accessToken], 200);
        } else {
            return response()->json(['message' => 'Login gagal, coba lagi'], 401);
        }
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('index');
        }

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
