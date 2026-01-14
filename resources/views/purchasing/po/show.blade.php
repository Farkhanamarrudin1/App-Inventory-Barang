@extends('layouts.app')

@section('title', 'Detail Purchase Order')

@section('contents')

<div class="card shadow">
  <div class="card-body">

    <h4>Detail Purchase Order</h4>

    <p><strong>No PO :</strong> {{ $po->po_number }}</p>
    <p><strong>Tanggal :</strong> {{ $po->po_date }}</p>
    <p><strong>Supplier :</strong> {{ $po->supplier_name }}</p>
    <p><strong>Alamat :</strong> {{ $po->supplier_address }}</p>
    <p>Status: {!! poStatusBadge($po->status) !!}</p>


    <hr>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Barang</th>
          <th>Qty</th>
          <th>Harga</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($po->items as $item)
        <tr>
          <td>{{ $item->barang->nama_barang }}</td>
          <td>{{ $item->qty }}</td>
          <td>{{ number_format($item->price) }}</td>
          <td>{{ number_format($item->total) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <a href="{{ route('gr.create.from.po', $po->id) }}" class="btn btn-success mt-3">
        Buat Goods Receipt
    </a>

  </div>
</div>

@endsection
