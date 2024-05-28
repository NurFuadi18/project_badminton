<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\barang;
use App\Models\pelanggan;
use App\Models\User;
class HomeController extends Controller
{
    public function index()
    {
        $jumlahPelanggan = pelanggan::count();
        $jumlahAdmin = User::count();
        $pendapatanPerMinggu = 5000000; // Contoh statis, seharusnya hitung dari database
        
        return view('index', [
            'jumlahPelanggan' => $jumlahPelanggan,
            'jumlahAdmin' => $jumlahAdmin,
            'pendapatanPerMinggu' => $pendapatanPerMinggu,
        ]);
    }

    public function calendar()
    {
        return view('calendar');
    }
    
   
   
}
