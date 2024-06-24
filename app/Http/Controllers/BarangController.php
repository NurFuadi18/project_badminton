<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function tabelBarang()
    {
        $data = Barang::all();
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function($item) {
            return $item->harga * $item->quantity;
        });

        return view('databarang', compact('data', 'cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required',
            'nama_barang' => 'required',
            'jenis' => 'required',
            'harga' => 'required',
            'jumlah' => 'required|integer|min:1',
        ]);

        Barang::create([
            'id_barang' => $request->id_barang,
            'nama_barang' => $request->nama_barang,
            'jenis' => $request->jenis,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang = Barang::find($id);
        return view('editbarang', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->nama_barang = $request->input('nama_barang');
        $barang->jenis = $request->input('jenis');
        $barang->jumlah = $request->input('jumlah');
        $barang->save();

        return redirect()->route('databarang')->with('success', 'Data barang berhasil diperbarui.');
    }
}