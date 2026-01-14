@extends('layouts.app')

@section('title', 'Purchase Order')

@section('contents')

<div class="d-flex justify-content-between mb-3">
    <h4>Purchase Order</h4>
</div>

<div class="card shadow">
    <div class="card-body table-responsive">

        <table class="table table-bordered">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>PO Number</th>
                    <th>Supplier</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total Item</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $row->po_number }}</strong></td>
                    <td>{{ $row->supplier_name }}</td>
                    <td>{{ $row->po_date }}</td>
                    <td>{!! poStatusBadge($row->status) !!}</td>
                    <td>
                        <span class="badge badge-info">{{ $row->status }}</span>
                    </td>
                    <td>{{ $row->items->count() }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('po.show', $row->id) }}">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection
