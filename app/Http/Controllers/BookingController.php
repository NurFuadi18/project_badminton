<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Pelanggan; // Import model Pelanggan

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return view('booking', ['bookings' => $bookings]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id', // Pastikan ID pelanggan ada
            'lapangan_dipilih' => 'required|string',
            'tanggal_bermain' => 'required|date',
            'jam_dimulai' => 'required|string',
            'jam_diakhiri' => 'required|string',
            'equipment' => 'nullable|string',
        ]);

        // Ambil nama pengguna berdasarkan ID pelanggan
        $pelanggan = Pelanggan::find($request->input('pelanggan_id'));

        // Memberikan nilai default '-' jika equipment kosong
        $equipment = $request->input('equipment') ?? '-';

        $booking = Booking::create([
            'nama_pengirim' => $pelanggan->nama, 
            'lapangan_dipilih' => $request->input('lapangan_dipilih'),
            'tanggal_bermain' => $request->input('tanggal_bermain'),
            'jam_dimulai' => $request->input('jam_dimulai'),
            'jam_diakhiri' => $request->input('jam_diakhiri'),
            'equipment' => $equipment,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Booking berhasil', 'data' => $booking], 201);
    }

    // Tambahkan fungsi lainnya seperti update dan delete sesuai kebutuhan aplikasi Anda
}
