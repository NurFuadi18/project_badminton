<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\barang;
class HomeController extends Controller
{
    public function index()
    {
        $data=barang::all();
        return view('index', compact('data'));
    }

    public function calendar()
    {
        return view('calendar');
    }
    
   
   
}
