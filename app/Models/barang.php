<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{

   
    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'barang';
    
    /**
     * Kolom-kolom yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'nama_barang', 'jenis', 'jumlah'
    ];
    protected $primaryKey = 'id_barang';
}
