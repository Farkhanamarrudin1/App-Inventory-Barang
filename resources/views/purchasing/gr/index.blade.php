@extends('layouts.app')

@section('title', 'Goods Receipt')

@section('contents')

<div class="card shadow">
  <div class="card-body table-responsive">

    <table class="table table-bordered">
      <thead class="bg-primary text-white">
        <tr>
          <th>No</th>
          <th>GR Number</th>
          <th>Tanggal</th>
          <th>Total Item</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>
        @forelse ($data as $row)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $row->gr_number }}</td>
          <td>{{ $row->gr_date }}</td>
          <td>{{ $row->items->count() }}</td>
          <td>
            <a href="{{ route('gr.show', $row->id) }}" class="btn btn-info btn-sm">Detail</a>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center text-muted">Tidak ada data</td></tr>
        @endforelse
      </tbody>

    </table>

  </div>
</div>

@endsection
