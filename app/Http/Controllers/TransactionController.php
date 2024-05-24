<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function show($id)
    {
        $transaction = Transaction::with('items')->where('user_id', Auth::id())->findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }

    public function print($id)
    {
        $transaction = Transaction::with('items')->where('user_id', Auth::id())->findOrFail($id);

        $pdf = PDF::loadView('transactions.invoice', compact('transaction'));
        return $pdf->download('invoice.pdf');
    }
}
