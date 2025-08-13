<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use PDF;
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

    public function index(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_barang', 'like', "%{$request->search}%")
                    ->orWhere('kode_barang', 'like', "%{$request->search}%");
            });
        }

        if ($request->filter == 'keluar') {
            $query->whereNotNull('tanggal_keluar');
        } elseif ($request->filter == 'belum') {
            $query->whereNull('tanggal_keluar');
        }

        $barangs = $query->latest()->get();

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

    public function downloadPdf(Request $request)
    {
        // Filter data sesuai search & filter
        $query = Barang::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                    ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filter === 'keluar') {
            $query->whereNotNull('tanggal_keluar');
        } elseif ($request->filter === 'belum') {
            $query->whereNull('tanggal_keluar');
        }

        $barangs = $query->orderBy('created_at', 'desc')->get();

        // Load view PDF
        $pdf = PDF::loadView('pdf', compact('barangs'))->setPaper('a4', 'landscape');

        return $pdf->download('data-barang.pdf');
    }
}
