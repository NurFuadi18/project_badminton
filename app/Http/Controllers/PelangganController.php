<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Validator;

class PelangganController extends Controller
{

    public function profile(Request $request)
    {
        $email = $request->user()->email; // Mendapatkan email dari pengguna yang terautentikasi
        $pelanggan = Pelanggan::where('email', $email)->first(); // Mengambil pelanggan berdasarkan email

        if (!$pelanggan) {
            return response()->json(['message' => 'Pelanggan tidak ditemukan'], 404);
        }

        return response()->json($pelanggan);
    }

    public function updateProfile(Request $request)
    {
        $pelanggan = $request->user();

        $request->validate([
            'no_telp' => 'nullable|string|max:15',
        ]);

        $pelanggan->no_telp = $request->no_telp;
        $pelanggan->save();

        return response()->json(['message' => 'Profile updated successfully', 'pelanggan' => $pelanggan]);
    }
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
