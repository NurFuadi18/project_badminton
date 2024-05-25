<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class LaporanController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi
        $transactions = Transaction::all();
        
        // Tampilkan tampilan laporan transaksi dengan data transaksi
        return view('laporan', compact('transactions'));
    }
}
