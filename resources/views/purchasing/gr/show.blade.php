@extends('layouts.app')

@section('title', 'Detail Goods Receipt')

@section('contents')

<div class="card shadow">
  <div class="card-body">

    <h4>Detail Goods Receipt</h4>

    <p><strong>No GR:</strong> {{ $gr->gr_number }}</p>
    <p><strong>Tanggal:</strong> {{ $gr->gr_date }}</p>

    <hr>

    <h5>Item Diterima</h5>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Barang</th>
          <th>Qty</th>
          <th>Kondisi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($gr->items as $item)
        <tr>
          <td>{{ $item->barang->nama_barang }}</td>
          <td>{{ $item->received_qty }}</td>
          <td>{{ ucfirst($item->condition) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
</div>

@endsection
