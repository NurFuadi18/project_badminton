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

    public function index()
    {
        $transactions = Transaction::all();
        return view('transactions.index', compact('transactions'));
    }

    public function filter(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $transactions = Transaction::whereBetween('created_at', [$start_date, $end_date])->get();

        return view('transactions.index', compact('transactions'));
    }
}
