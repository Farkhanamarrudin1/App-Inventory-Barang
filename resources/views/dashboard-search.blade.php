@extends('layouts.app')

@section('title', 'Hasil Pencarian Dashboard')

@section('contents')
<div class="row mb-4">
  <div class="col">
    <h3 class="text-gray-800 font-weight-bold">Hasil Pencarian: "{{ $query }}"</h3>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm mt-2">
      <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
  </div>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Data Barang Ditemukan</h6>
  </div>
  <div class="card-body">
    @if($hasil->count() > 0)
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead class="table-primary">
            <tr>
              <th>No</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Kategori</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            @foreach($hasil as $index => $item)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kode_barang }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->kategori->nama ?? '-' }}</td>
                <td>{{ $item->jumlah }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="text-muted text-center mt-3">Tidak ada hasil ditemukan untuk "<b>{{ $query }}</b>".</p>
    @endif
  </div>
</div>
@endsection
