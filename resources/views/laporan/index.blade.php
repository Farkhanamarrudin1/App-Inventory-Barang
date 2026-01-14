<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pratinjau Laporan Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📄 Laporan Data Barang</h4>
        </div>
        <div class="card-body">
            {{-- ✅ Tanggal cetak real-time WIB --}}
            <p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i:s') }}</p>

            <h5>📦 Daftar Semua Barang</h5>
            <table class="table table-bordered table-striped mt-2">
                <thead class="table-secondary">
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
                    @foreach($barang as $b)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $b->kode_barang }}</td>
                        <td>{{ $b->nama_barang }}</td>
                        {{-- ✅ perbaikan nama kolom kategori --}}
                        <td>{{ optional($b->kategori)->nama ?? '-' }}</td>
                        <td>Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                        <td>{{ $b->jumlah }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h5 class="mt-4 text-danger">⚠ Barang Hampir Habis (Stok < 10)</h5>
            <table class="table table-bordered mt-2">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangHampirHabis as $b)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $b->nama_barang }}</td>
                        {{-- ✅ kolom kategori juga disesuaikan --}}
                        <td>{{ optional($b->kategori)->nama ?? '-' }}</td>
                        <td>{{ $b->jumlah }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tidak ada barang hampir habis</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="text-end mt-4">
                <a href="{{ route('laporan.download') }}" class="btn btn-success">
                    ⬇ Download PDF
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
