@extends('layouts.app')

@section('title', 'Buat Purchase Order')

@section('contents')

<div class="card shadow">
  <div class="card-body">

    <form action="{{ route('po.store') }}" method="POST">
      @csrf

      <input type="hidden" name="purchase_request_id" value="{{ $pr->id }}">

      <h4>Purchase Order</h4>
      <p><strong>Dari PR:</strong> {{ $pr->pr_number }}</p>

      <div class="form-group">
        <label>Supplier</label>
        <input type="text" name="supplier_name" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Alamat Supplier</label>
        <textarea name="supplier_address" class="form-control"></textarea>
      </div>

      <div class="form-group">
        <label>Tanggal PO</label>
        <input type="date" name="po_date" class="form-control" required>
      </div>

      <hr>
      <h5>Item Barang</h5>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Barang</th>
            <th>Qty</th>
            <th>Harga</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pr->items as $item)
          <tr>
            <td>
              {{ $item->barang->nama_barang }}
              <input type="hidden" name="items[{{$loop->index}}][barang_id]" value="{{ $item->barang_id }}">
            </td>
            <td>
              <input type="number" name="items[{{$loop->index}}][qty]" class="form-control" value="{{ $item->qty }}">
            </td>
            <td>
              <input type="number" name="items[{{$loop->index}}][price]" class="form-control" required>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <button type="submit" class="btn btn-primary">Simpan PO</button>
    </form>

  </div>
</div>

@endsection
