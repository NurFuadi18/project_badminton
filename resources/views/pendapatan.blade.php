<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('status', 'pending')->get();
        $approvedBookings = Booking::where('status', 'approved')->get();
        
        return view('booking', compact('bookings', 'approvedBookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengirim' => 'required|string',
            'lapangan_dipilih' => 'required|string',
            'tanggal_bermain' => 'required|date_format:Y-m-d',
            'jam_dimulai' => 'required|date_format:H:i',
            'jam_diakhiri' => 'required|date_format:H:i',
            'equipment' => 'nullable|string',
        ]);

        $jamDimulai = Carbon::createFromFormat('H:i', $request->input('jam_dimulai'));
        $jamDiakhiri = Carbon::createFromFormat('H:i', $request->input('jam_diakhiri'));

        $tanggal_bermain = Carbon::createFromFormat('Y-m-d', $request->input('tanggal_bermain'));

        $conflictingBookings = Booking::where('lapangan_dipilih', $request->input('lapangan_dipilih'))
            ->where('tanggal_bermain', $tanggal_bermain->format('Y-m-d'))
            ->where(function ($query) use ($jamDimulai, $jamDiakhiri) {
                $query->where(function ($query) use ($jamDimulai, $jamDiakhiri) {
                        $query->where('jam_dimulai', '>=', $jamDimulai)
                                ->where('jam_dimulai', '<', $jamDiakhiri);
                    })
                    ->orWhere(function ($query) use ($jamDimulai, $jamDiakhiri) {
                        $query->where('jam_diakhiri', '>', $jamDimulai)
                                ->where('jam_diakhiri', '<=', $jamDiakhiri);
                    })
                    ->orWhere(function ($query) use ($jamDimulai, $jamDiakhiri) {
                        $query->where('jam_dimulai', '<=', $jamDimulai)
                                ->where('jam_diakhiri', '>=', $jamDiakhiri);
                    });
            })
            ->get();

        if ($conflictingBookings->count() > 0) {
            return response()->json(['error' => 'Slot waktu sudah diambil'], 409);
        }

        $booking = new Booking();
        $booking->nama_pengirim = $request->input('nama_pengirim');
        $booking->lapangan_dipilih = $request->input('lapangan_dipilih');
        $booking->tanggal_bermain = $request->input('tanggal_bermain');
        $booking->jam_dimulai = $jamDimulai->format('H:i');
        $booking->jam_diakhiri = $jamDiakhiri->format('H:i');
        $booking->equipment = $request->input('equipment', '-');
        $booking->status = 'pending';
        $booking->save();

        return response()->json($booking, 201);
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'pendapatan' => 'required|integer',
            'bayar' => 'required|integer',
        ]);

        $booking = Booking::find($id);

        if ($booking) {
            $booking->status = 'approved';
            $booking->pendapatan = $request->input('pendapatan');
            $booking->save();

            $kembalian = $request->input('bayar') - $request->input('pendapatan');

            return redirect()->route('bookings.index')->with('success', 'Booking approved. Kembalian: ' . $kembalian);
        } else {
            return redirect()->route('bookings.index')->with('error', 'Booking not found');
        }
    }

    public function report()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $pendapatan = Booking::whereBetween('tanggal_bermain', [$startOfWeek, $endOfWeek])
            ->where('status', 'approved')
            ->sum('pendapatan');

        return response()->json(['pendapatan' => $pendapatan], 200);
    }

    public function accept(Request $request, $id)
    {
        $request->validate([
            'pendapatan' => 'required|numeric',
            'bayar' => 'required|numeric',
        ]);

        $booking = Booking::find($id);

        if ($booking) {
            $booking->status = 'approved';
            $booking->pendapatan = $request->input('pendapatan');
            $booking->save();
            
            $kembalian = $request->input('bayar') - $request->input('pendapatan');

            return redirect()->route('bookings.index')->with('success', 'Booking approved. Kembalian: ' . $kembalian);
        } else {
            return redirect()->route('bookings.index')->with('error', 'Booking not found');
        }
    }

    public function reject($id)
    {
        $booking = Booking::find($id);

        if ($booking) {
            $booking->status = 'rejected';
            $booking->save();

            return redirect()->route('bookings.index')->with('success', 'Booking rejected');
        } else {
            return redirect()->route('bookings.index')->with('error', 'Booking not found');
        }
    }

    public function showPendapatan()
    {
        $pendapatanBookings = Booking::where('status', 'approved')->get();

        return view('pendapatan', compact('pendapatanBookings'));
    }

    public function showWeeklyPendapatan()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $pendapatanBookings = Booking::where('status', 'approved')
            ->whereBetween('tanggal_bermain', [$startOfWeek, $endOfWeek])
            ->get();

        $totalPendapatan = $pendapatanBookings->sum('pendapatan');

        return view('pendapatan', compact('pendapatanBookings', 'totalPendapatan'));
    }
}
