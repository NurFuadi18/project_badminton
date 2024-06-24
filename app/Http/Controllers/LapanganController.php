<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    public function getLapanganImage($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        $gambarPath = public_path("/images/{$lapangan->gambar}");

        // Pastikan file gambar ada
        if (!file_exists($gambarPath)) {
            abort(404);
        }

        // Membuat respons dengan file gambar
        return response()->file($gambarPath);
    }
    public function tampillapangan()
    {
        $lapangans = Lapangan::all();
        $lapangans->transform(function ($lapangan) {
            $lapangan->gambar = url('images/' . $lapangan->gambar);
            return $lapangan;
        });
        return response()->json($lapangans);
    }
    public function index()
    {
        $lapangans = Lapangan::all();
        return view('manajemenlapangan.lapangan', compact('lapangans'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'harga' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan file gambar di direktori publik
        $imageName = time() . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('images'), $imageName);

        // Buat objek Lapangan baru dan simpan ke database
        $lapangan = new Lapangan([
            'nama' => $request->get('nama'),
            'harga' => $request->get('harga'),
            'gambar' => $imageName, // Simpan nama file gambar
        ]);

        // Simpan data lapangan ke database
        $lapangan->save();

        // Redirect ke halaman daftar lapangan dengan pesan sukses
        return redirect('/lapangan')->with('success', 'Lapangan telah ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $lapangan = Lapangan::find($id);

        $request->validate([
            'nama' => 'required',
            'harga' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $imageName = time().'.'.$request->gambar->extension();  
            $request->gambar->move(public_path('images'), $imageName);
            Storage::delete($lapangan->gambar); // Delete old image
            $lapangan->gambar = '/images/' . $imageName;
        }

        $lapangan->nama = $request->get('nama');
        $lapangan->harga = $request->get('harga');
        $lapangan->save();

        return redirect()->route('lapangan.index')->with('success', 'Lapangan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $lapangan = Lapangan::find($id);
        Storage::delete($lapangan->gambar); // Delete associated image
        $lapangan->delete();

        return redirect()->route('lapangan.index')->with('success', 'Lapangan berhasil dihapus');
    }
}
