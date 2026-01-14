@extends('layouts.app')

@section('title', 'Tambah Purchase Request')

@section('contents')

<div class="card shadow">
  <div class="card-body">

    <form action="{{ route('pr.store') }}" method="POST">
      @csrf

      <div class="form-group">
        <label>Tanggal PR</label>
        <input type="date" name="pr_date" class="form-control" required>
      </div>

      <hr>
      <h5>Item Barang</h5>

      <table class="table" id="item-table">
        <thead>
          <tr>
            <th>Barang</th>
            <th>Qty</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>

      <button type="button" class="btn btn-secondary mb-3" onclick="addRow()">+ Tambah Item</button>

      <button type="submit" class="btn btn-primary">Simpan PR</button>

    </form>

  </div>
</div>

<script>
let itemIndex = 0;

function addRow() {
    const barangOptions = @json($barang->map(fn($b) => ['id' => $b->id, 'nama' => $b->nama_barang]));

    let row = `
      <tr>
        <td>
          <select name="items[${itemIndex}][barang_id]" class="form-control" required>
            ${barangOptions.map(b => `<option value="${b.id}">${b.nama}</option>`).join('')}
          </select>
        </td>
        <td>
          <input type="number" name="items[${itemIndex}][qty]" class="form-control" min="1" required>
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">X</button>
        </td>
      </tr>
    `;

    document.querySelector('#item-table tbody').insertAdjacentHTML('beforeend', row);
    itemIndex++;
}
</script>

@endsection
