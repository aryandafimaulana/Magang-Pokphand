<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalStok = Barang::whereNull('tanggal_keluar')->sum('stok');
        $stokMasukHariIni = Barang::whereDate('tanggal_masuk', today())->count();
        $stokKeluarHariIni = Barang::whereDate('tanggal_keluar', today())->count();
        $barangTerbaru = Barang::latest()->take(5)->get();

        return view('dashboard', compact('totalBarang', 'totalStok','stokMasukHariIni', 'stokKeluarHariIni', 'barangTerbaru'));
    }
}
