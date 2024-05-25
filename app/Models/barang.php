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
    protected $table = 'barangs';
    
    /**
     * Kolom-kolom yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'nama_barang', 'jenis','harga', 'jumlah'
    ];
    protected $primaryKey = 'id_barang';
}
