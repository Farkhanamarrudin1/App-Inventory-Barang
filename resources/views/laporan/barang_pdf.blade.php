<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan Data Barang</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    h2, h3 { text-align: center; margin-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    th { background-color: #e0e0e0; }
    .footer { text-align: right; font-size: 11px; margin-top: 15px; }
  </style>
</head>
<body>
  <h2>Laporan Data Barang</h2>

  <h3>📦 Daftar Semua Barang</h3>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($barang as $index => $item)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $item->kode_barang }}</td>
        <td>{{ $item->nama_barang }}</td>
        <td>{{ optional($item->kategori)->nama ?? '-' }}</td>
        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
        <td>{{ $item->jumlah }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align:center;">Tidak ada data barang.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <h3>⚠️ Barang Hampir Habis (Stok < 10)</h3>
  @if ($barangHampirHabis->count() > 0)
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($barangHampirHabis as $index => $item)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $item->nama_barang }}</td>
        <td>{{ optional($item->kategori)->nama ?? '-' }}</td>
        <td>{{ $item->jumlah }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <p style="text-align:center;">Semua stok barang masih aman ✅</p>
  @endif

  <div class="footer">
    Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i:s') }}
  </div>
</body>
</html>
