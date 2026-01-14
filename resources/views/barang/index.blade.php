@extends('layouts.app')

@section('title', 'Data Barang')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>

      {{-- 🔍 Form Pencarian --}}
      <form action="{{ route('barang') }}" method="GET" class="d-flex" style="max-width: 350px;">
        <input type="text" name="q" class="form-control me-2" placeholder="Cari barang atau kategori..."
               value="{{ request('q') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
      </form>
    </div>

    <div class="card-body">
      @if (auth()->user()->level == 'Admin')
        <a href="{{ route('barang.tambah') }}" class="btn btn-primary mb-3">Tambah Barang</a>
      @endif

      <div class="table-responsive">
        @if ($data->count() > 0)
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Kategori</th>
              <th>Harga</th>
              <th>Jumlah</th>
              @if (auth()->user()->level == 'Admin')
                <th>Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($data as $row)
              <tr>
                <th>{{ $no++ }}</th>
                <td>{{ $row->kode_barang }}</td>
                <td>{{ $row->nama_barang }}</td>
                <td>{{ $row->kategori->nama ?? '-' }}</td>
                <td>Rp {{ number_format($row->harga, 0, ',', '.') }}</td>
                <td>{{ $row->jumlah }}</td>
                @if (auth()->user()->level == 'Admin')
                  <td>
                    <a href="{{ route('barang.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('barang.hapus', $row->id) }}" class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
                  </td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
        @else
          <div class="alert alert-warning text-center">
            <strong>Barang tidak ditemukan.</strong>
            @if(request('q'))
              <br><small>Hasil pencarian untuk: <b>{{ request('q') }}</b></small>
            @endif
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
