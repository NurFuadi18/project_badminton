<?php

namespace App\Http\Controllers;
use App\Models\barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{

    public function tabelbarang()
    {
       $data=barang::all();
       return view('databarang', compact('data'));
    }



    public function store(Request $request)
{
    // Validasi data yang dikirimkan
    $request->validate([
        'id_barang' => 'required',
        'nama_barang' => 'required',
        'jenis' => 'required',
        'jumlah' => 'required|integer|min:1',
    ]);

    // Simpan data barang ke database
    barang::create([
        'id_barang' => $request->id_barang,
        'nama_barang' => $request->nama_barang,
        'jenis' => $request->jenis,
        'jumlah' => $request->jumlah,
    ]);

    // Redirect kembali ke halaman sebelumnya dengan pesan sukses
    return redirect()->back()->with('success', 'Barang berhasil ditambahkan.');
}

public function edit($id)
    {
        $barang = barang::find($id);
        return view('editbarang', compact('barang'));
    }

    // Method untuk mengupdate data barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jenis' => 'required',
            'jumlah' => 'required|integer',
        ]);

        $barang = barang::find($id);
        $barang->update($request->all());

        return redirect()->route('databarang')->with('success', 'Data barang berhasil diperbarui');
    }


}
