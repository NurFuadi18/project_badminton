<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id_barang',
            'quantity' => 'required|integer|min:1',
        ]);

        $barang = Barang::find($request->id_barang);
        $quantity = $request->quantity;

        if ($barang && $barang->jumlah >= $quantity) {
            $barang->jumlah -= $quantity;
            $barang->save();

            if (Auth::check()) {
                Cart::create([
                    'user_id' => Auth::id(),
                    'barang_id' => $barang->id_barang,
                    'nama_barang' => $barang->nama_barang,
                    'harga' => $barang->harga,
                    'quantity' => $quantity,
                ]);
                return response()->json(['success' => true, 'message' => 'Barang berhasil ditambahkan ke keranjang.', 'new_quantity' => $barang->jumlah]);
            } else {
                return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Stok barang tidak mencukupi.'], 400);
        }
    }

    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function($item) {
            return $item->harga * $item->quantity;
        });

        return view('barangs.cart', compact('cartItems', 'total'));
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function($item) {
            return $item->harga * $item->quantity;
        });

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'total' => $total
        ]);

        foreach ($cartItems as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'barang_id' => $item->barang_id,
                'nama_barang' => $item->nama_barang,
                'harga' => $item->harga,
                'quantity' => $item->quantity,
            ]);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('transaction.show', $transaction->id)->with('success', 'Transaksi berhasil');
    }

    public function remove($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Item removed from cart');
        }

        return redirect()->route('cart.index')->with('error', 'Item not found in cart');
    }
}
