@extends('layouts.app')

@section('title', 'Detail Purchase Request')

@section('contents')

<div class="card shadow">
    <div class="card-body">

        <h4 class="mb-3">Detail Purchase Request</h4>

        <p><strong>No PR:</strong> {{ $pr->pr_number }}</p>
        <p><strong>Tanggal PR:</strong> {{ $pr->pr_date }}</p>
        <p><strong>Requester:</strong> {{ $pr->creator->nama ?? 'Unknown' }}</p>

        <p>
            <strong>Status:</strong>
            @if ($pr->status == 'Pending')
                <span class="badge bg-warning">Pending</span>
            @elseif ($pr->status == 'Approved')
                <span class="badge bg-success">Approved</span>
            @elseif ($pr->status == 'Rejected')
                <span class="badge bg-danger">Rejected</span>
            @endif
        </p>

        @if ($pr->approved_by)
        <p>
            <strong>Disetujui Oleh:</strong> 
            {{ $pr->approver->nama ?? 'Unknown' }} <br>
            <small>Tanggal: {{ $pr->approved_at }}</small>
        </p>
        @endif

        <hr>

        <h5>Daftar Item Barang</h5>

        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($pr->items as $item)
                <tr>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->unit }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr>

        {{-- BUTTON APPROVAL --}}
        @if ($pr->status == 'Pending')
            <div class="mt-3">
                <form action="{{ route('pr.approve', $pr->id) }}" method="POST" style="display:inline">
                    @csrf
                    <button class="btn btn-success">Approve</button>
                </form>

                <form action="{{ route('pr.reject', $pr->id) }}" method="POST" style="display:inline">
                    @csrf
                    <button class="btn btn-danger">Reject</button>
                </form>
            </div>
        @endif

        {{-- BUTTON BUAT PO --}}
        @if ($pr->status == 'Approved')
            <a href="{{ route('po.create.from.pr', $pr->id) }}" class="btn btn-primary mt-4">
                Buat Purchase Order (PO)
            </a>
        @endif

    </div>
</div>

@endsection
