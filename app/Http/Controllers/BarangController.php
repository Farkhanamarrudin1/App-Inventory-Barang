<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kata kunci dari form pencarian
        $q = $request->input('q');

        // Query barang dengan filter pencarian (nama, kode, kategori)
        $barang = Barang::with('kategori')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nama_barang', 'like', "%{$q}%")
                        ->orWhere('kode_barang', 'like', "%{$q}%")
                        ->orWhereHas('kategori', function ($kategori) use ($q) {
                            $kategori->where('nama', 'like', "%{$q}%");
                        });
                });
            })
            ->get();

        return view('barang.index', ['data' => $barang]);
    }

    public function tambah()
    {
        $kategori = Kategori::all();
        return view('barang.form', ['kategori' => $kategori]);
    }

    public function simpan(Request $request)
    {
        $data = $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'id_kategori' => 'required',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ]);

        Barang::create($data);
        return redirect()->route('barang')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = Kategori::all();

        return view('barang.form', compact('barang', 'kategori'));
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'id_kategori' => 'required',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ]);

        Barang::findOrFail($id)->update($data);
        return redirect()->route('barang')->with('success', 'Barang berhasil diperbarui');
    }

    public function hapus($id)
    {
        Barang::findOrFail($id)->delete();
        return redirect()->route('barang')->with('success', 'Barang berhasil dihapus');
    }
}
