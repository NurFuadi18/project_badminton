<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;

class MakananController extends Controller
{
    public function index()
    {
        $barangs = Makanan::all();
        return view('makanan.index', compact('barangs'));
    }

    public function create()
    {
        return view('makanan.create');
    }

    public function store(Request $request)
    {
        Makanan::create($request->all());
        return redirect()->route('makanan.index');
    }
}
