<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }

    public function tambah()
    {
        return view('kategori.form');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100'
        ]);

        Kategori::create(['nama' => $request->nama]);

        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.form', compact('kategori'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update(['nama' => $request->nama]);

        return redirect()->route('kategori')->with('success', 'Kategori berhasil diperbarui');
    }

    public function hapus($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();

            return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus');
        } catch (QueryException $e) {
            // Error karena foreign key constraint (masih dipakai di tabel barang)
            if ($e->getCode() == "23000") {
                return redirect()->route('kategori')->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh data barang');
            }

            // Jika error lain
            return redirect()->route('kategori')->with('error', 'Terjadi kesalahan saat menghapus kategori');
        }
    }
}
