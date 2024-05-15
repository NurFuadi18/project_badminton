<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;
use DB;
class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('barang')->insert([
            'id_barang' => '001',
            'nama_barang' => 'Raket Yonex',
            'jenis' => 'Alat',
            'jumlah' => '5',
            // tambahkan data lainnya sesuai kebutuhan
        ]);
    }
}
