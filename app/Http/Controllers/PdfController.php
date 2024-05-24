<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Makanan;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePdf()
    {
        $makanan = Makanan::all();
        $transaksi = Transaksi::all();

        $pdf = PDF::loadView('pdf.makanan_transaksi', compact('makanan', 'transaksi'));

        return $pdf->download('laporan.pdf');
    }
}
