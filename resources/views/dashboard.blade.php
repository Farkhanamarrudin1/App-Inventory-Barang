@extends('layouts.app')

@section('title', 'Inventory App')

@section('contents')
<div class="row mb-4">
  <div class="col">
    <h3 class="text-gray-800 font-weight-bold">Selamat Datang Admin</h3>
  </div>
</div>

<div class="row">
  <!-- Total Barang -->
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Barang</div>
          <div id="total-barang" class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBarang }}</div>
        </div>
        <i class="fas fa-box fa-2x text-gray-300"></i>
      </div>
    </div>
  </div>

  <!-- Total Kategori -->
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Kategori</div>
          <div id="total-kategori" class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKategori }}</div>
        </div>
        <i class="fas fa-tags fa-2x text-gray-300"></i>
      </div>
    </div>
  </div>

  <!-- Barang Hampir Habis -->
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Barang Hampir Habis</div>
          <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
        </div>
        <ul id="barang-habis" class="mb-0" style="list-style:none; padding-left:0;">
          @forelse ($barangMenipis as $item)
            <li class="text-gray-800 small">• {{ $item->nama_barang }} ({{ $item->jumlah }})</li>
          @empty
            <li class="text-muted small">Tidak ada barang hampir habis</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>

{{-- 🔍 Hasil Pencarian (kalau ada query q dari search bar) --}}
@if(request('q'))
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
      Hasil Pencarian untuk: "{{ request('q') }}"
    </h6>
  </div>
  <div class="card-body">
    @if(isset($results) && $results->count() > 0)
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="thead-light">
            <tr>
              <th>No</th>
              <th>Nama Barang</th>
              <th>Kategori</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($results as $index => $barang)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->kategori->nama ?? '-' }}</td>
                <td>{{ $barang->jumlah }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="text-muted">Tidak ditemukan hasil untuk pencarian ini.</p>
    @endif
  </div>
</div>
@endif

<!-- Script realtime update -->
<script>
  async function updateDashboard() {
    try {
      const response = await fetch('/api/dashboard-data');
      const data = await response.json();

      document.getElementById('total-barang').textContent = data.totalBarang;
      document.getElementById('total-kategori').textContent = data.totalKategori;

      const listContainer = document.getElementById('barang-habis');
      listContainer.innerHTML = '';
      if (data.barangMenipis.length > 0) {
        data.barangMenipis.forEach(item => {
          const li = document.createElement('li');
          li.classList.add('text-gray-800', 'small');
          li.textContent = `• ${item.nama_barang} (${item.jumlah})`;
          listContainer.appendChild(li);
        });
      } else {
        listContainer.innerHTML = '<li class="text-muted small">Tidak ada barang hampir habis</li>';
      }
    } catch (err) {
      console.error('Gagal memuat data dashboard:', err);
    }
  }

  updateDashboard();
  setInterval(updateDashboard, 10000);
</script>
@endsection
