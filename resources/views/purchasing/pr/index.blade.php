@extends('layouts.app')

@section('title', 'Purchase Request')

@section('contents')

<div class="d-flex justify-content-between mb-3">
    <h4>Purchase Request</h4>
    <a href="{{ route('pr.create') }}" class="btn btn-primary">+ Tambah PR</a>
</div>

<div class="card shadow">
    <div class="card-body table-responsive">

        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>PR Number</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total Item</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $row)
                <tr>
                    <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>

                    <td><strong>{{ $row->pr_number }}</strong></td>

                    <td>{{ $row->pr_date }}</td>

                    <td>
                        @if ($row->status == 'Pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif ($row->status == 'Approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif ($row->status == 'Rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>

                    <td>{{ $row->items->count() }}</td>

                    <td>
                        <a href="{{ route('pr.show', $row->id) }}" class="btn btn-sm btn-info">
                            Detail
                        </a>

                        {{-- DELETE --}}
                        <form action="{{ route('pr.delete', $row->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Yakin hapus PR ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>

                        {{-- APPROVAL BUTTON (optional) --}}
                        @if ($row->status == 'Pending')
                            <form action="{{ route('pr.approve', $row->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success">Approve</button>
                            </form>

                            <form action="{{ route('pr.reject', $row->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-warning text-dark">Reject</button>
                            </form>
                        @endif
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $data->links() }}
        </div>

    </div>
</div>

@endsection
