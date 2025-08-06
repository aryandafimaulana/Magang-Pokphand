<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Carbon\Carbon;

class BarangController extends Controller
{
    public function barangKeluar($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->tanggal_keluar = now(); // isi dengan waktu sekarang
        $barang->save();

        return redirect()->back()->with('success', 'Tanggal keluar berhasil diisi!');
    }

    public function index()
    {
        $barangs = Barang::latest()->get(); // ambil semua barang terbaru
        return view('barang', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang',
            'nama_barang' => 'required',
            'stok' => 'required|integer',
            'tanggal_masuk' => 'required|date',
        ], [
            'kode_barang.unique' => 'Kode barang harus unik!',
            'stok.min' => 'Stok tidak boleh kurang dari 1!'
        ]);

        Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'stok' => $request->stok,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'stok' => 'required|integer',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'stok' => $request->stok,
            // tanggal_masuk & tanggal_keluar tidak diedit
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }
}
