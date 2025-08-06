<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Barang::create([
            'kode_barang' => 'BRG001',
            'nama_barang' => 'Monitor',
            'stok' => 25,
            'tanggal_masuk' => '2025-08-01',
            'tanggal_keluar' => '2025-08-06'
        ]);

        \App\Models\Barang::create([
            'kode_barang' => 'BRG002',
            'nama_barang' => 'Keyboard',
            'stok' => 50,
            'tanggal_masuk' => '2025-08-03',
            'tanggal_keluar' => null
        ]);
    }
}
