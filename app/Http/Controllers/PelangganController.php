<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pelanggan;

class PelangganController extends Controller
{
    public function daftarpelanggan(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:pelanggans',
            'password' => 'required|min:6',
            'username' => 'required|unique:pelanggans'
        ]);

        $pelanggan = pelanggan::create([
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'username' => $validatedData['username']
        ]);

        $token = $pelanggan->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Pendaftaran berhasil', 'token' => $token], 200);
    }

    public function index()
    {
        $jumlahPelanggan = pelanggan::count();
        return view('index', ['jumlahPelanggan' => $jumlahPelanggan]);
    }
}
