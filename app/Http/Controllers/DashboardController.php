<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $barangMenipis = Barang::where('jumlah', '<=', 5)->get();

        return view('dashboard', compact('totalBarang', 'totalKategori', 'barangMenipis'));
    }

    public function getDashboardData()
    {
        $barangMenipis = Barang::where('jumlah', '<=', 5)->get(['nama_barang', 'jumlah']);

        return response()->json([
            'totalBarang' => Barang::count(),
            'totalKategori' => Kategori::count(),
            'barangMenipis' => $barangMenipis,
        ]);
    }

    // 🔍 Fungsi baru untuk fitur search di dashboard (topbar)
    public function search(Request $request)
    {
        $q = $request->input('q');

        // Jika tidak ada input, kembali ke dashboard biasa
        if (empty($q)) {
            return redirect()->route('dashboard');
        }

        // Cari barang berdasarkan nama, kode, atau kategori
        $hasil = Barang::with('kategori')
            ->where('nama_barang', 'like', "%{$q}%")
            ->orWhere('kode_barang', 'like', "%{$q}%")
            ->orWhereHas('kategori', function ($kategori) use ($q) {
                $kategori->where('nama', 'like', "%{$q}%");
            })
            ->get();

        return view('dashboard-search', [
            'query' => $q,
            'hasil' => $hasil
        ]);
    }
}
