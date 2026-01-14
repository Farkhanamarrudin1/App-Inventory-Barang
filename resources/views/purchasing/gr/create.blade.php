@extends('layouts.app')

@section('title', 'Penerimaan Barang')

@section('contents')

<div class="card shadow">
  <div class="card-body">

    <form action="{{ route('gr.store') }}" method="POST">
      @csrf

      <input type="hidden" name="purchase_order_id" value="{{ $po->id }}">

      <h4>Penerimaan Barang (Goods Receipt)</h4>
      <p><strong>Dari PO:</strong> {{ $po->po_number }}</p>

      <div class="form-group">
        <label>Tanggal Penerimaan</label>
        <input type="date" name="gr_date" class="form-control" required>
      </div>

      <hr>

      <h5>Item Barang Diterima</h5>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Barang</th>
            <th>Qty Pesanan</th>
            <th>Qty Diterima</th>
            <th>Kondisi</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($po->items as $item)
          <tr>
            <td>{{ $item->barang->nama_barang }}</td>
            <td>{{ $item->qty }}</td>
            <td>
              <input type="number" 
                     name="items[{{ $loop->index }}][received_qty]" 
                     class="form-control"
                     min="1"
                     required>

              <input type="hidden" name="items[{{ $loop->index }}][barang_id]" 
                     value="{{ $item->barang_id }}">
            </td>

            <td>
              <select name="items[{{ $loop->index }}][condition]" class="form-control">
                <option value="baik">Baik</option>
                <option value="rusak">Rusak</option>
              </select>
            </td>
          </tr>
          @endforeach
        </tbody>

      </table>

      <button type="submit" class="btn btn-primary">Simpan GR</button>

    </form>

  </div>
</div>

@endsection
