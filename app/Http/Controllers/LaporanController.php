<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Halaman pratinjau laporan
    public function index()
    {
        // Load relasi kategori agar kolom kategori tidak kosong
        $barang = Barang::with('kategori')->get();
        $barangHampirHabis = Barang::with('kategori')
            ->where('jumlah', '<', 10)
            ->get();

        // Gunakan waktu lokal (Asia/Jakarta) agar sesuai dengan waktu laptop
        $tanggalCetak = Carbon::now('Asia/Jakarta')->format('d/m/Y H:i:s');

        return view('laporan.index', compact('barang', 'barangHampirHabis', 'tanggalCetak'));
    }

    // Fungsi download PDF
    public function downloadPDF()
    {
        $barang = Barang::with('kategori')->get();
        $barangHampirHabis = Barang::with('kategori')
            ->where('jumlah', '<', 10)
            ->get();

        // Gunakan waktu lokal juga di PDF
        $tanggalCetak = Carbon::now('Asia/Jakarta')->format('d/m/Y H:i:s');

        $pdf = Pdf::loadView('laporan.barang_pdf', compact('barang', 'barangHampirHabis', 'tanggalCetak'))
            ->setPaper('a4', 'portrait');

        // Nama file juga otomatis mengikuti waktu real
        return $pdf->download('laporan_barang_' . Carbon::now('Asia/Jakarta')->format('Ymd_His') . '.pdf');
    }
}
