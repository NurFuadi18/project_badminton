<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengirim' => 'required|string',
            'lapangan_dipilih' => 'required|string',
            'tanggal_bermain' => 'required|date',
            'jam_dimulai' => 'required|string',
            'jam_diakhiri' => 'required|string',
            'equipment' => 'nullable|string',
        ]);

        // Memberikan nilai default '-' jika equipment kosong
        $equipment = $request->input('equipment') ?? '-';

        $booking = Booking::create([
            'nama_pengirim' => $request->input('nama_pengirim'),
            'lapangan_dipilih' => $request->input('lapangan_dipilih'),
            'tanggal_bermain' => $request->input('tanggal_bermain'),
            'jam_dimulai' => $request->input('jam_dimulai'),
            'jam_diakhiri' => $request->input('jam_diakhiri'),
            'equipment' => $equipment,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Booking created successfully', 'data' => $booking], 201);
    }

    // Tambahkan fungsi lainnya seperti update dan delete sesuai kebutuhan aplikasi Anda
}
