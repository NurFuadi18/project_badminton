<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pengirim',
        'lapangan_dipilih',
        'tanggal_bermain',
        'jam_dimulai',
        'jam_diakhiri',
        'equipment', 
        'status',
        'pendapatan'
    ];
}
