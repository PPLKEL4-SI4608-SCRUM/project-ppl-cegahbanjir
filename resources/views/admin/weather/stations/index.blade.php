@extends('layouts.admin')

@section('title', 'Manajemen Stasiun Cuaca')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manajemen Stasiun Cuaca</h1>
        <a href="{{ route('admin.weather.stations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Stasiun
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($stations->isEmpty())
                <div class="alert alert-info">
                    Belum ada stasiun cuaca yang terdaftar. Silakan tambahkan stasiun baru.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Koordinat</th>
                                <th>Status</th>
                                <th>Terakhir Diperbarui</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stations as $station)
                                <tr>
                                    <td>{{ $station->name }}</td>
                                    <td>{{ $station->location }}</td>
                                    <td>{{ $station->latitude }}, {{ $station->longitude }}</td>
                                    <td>
                                        @if($station->status == 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($station->status == 'maintenance')
                                            <span class="badge bg-warning">Pemeliharaan</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>{{ $station->updated_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.weather.stations.edit', $station) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.weather.stations.destroy', $station) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus stasiun ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $stations->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
