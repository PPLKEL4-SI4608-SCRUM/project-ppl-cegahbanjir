@extends('layouts.admin')
@section('title', 'Manajemen Parameter Peringatan Banjir')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manajemen Parameter Peringatan Banjir</h1>
        <a href="{{ route('admin.weather.parameters.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Parameter
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            @if($parameters->isEmpty())
                <div class="alert alert-info">
                    Belum ada parameter peringatan banjir yang ditentukan. Silakan tambahkan parameter baru.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Stasiun Cuaca</th>
                                <th>Threshold Rendah (mm)</th>
                                <th>Threshold Sedang (mm)</th>
                                <th>Threshold Tinggi (mm)</th>
                                <th>Threshold Sangat Tinggi (mm)</th>
                                <th>Hari Berturut-turut</th>
                                <th>Status</th>
                                <th>Terakhir Diperbarui</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parameters as $parameter)
                                <tr>
                                    <td>{{ $parameter->weatherStation->name }}</td>
                                    <td>{{ $parameter->threshold_low }}</td>
                                    <td>{{ $parameter->threshold_medium }}</td>
                                    <td>{{ $parameter->threshold_high }}</td>
                                    <td>{{ $parameter->threshold_very_high }}</td>
                                    <td>{{ $parameter->consecutive_days }}</td>
                                    <td>
                                        @if($parameter->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>{{ $parameter->updated_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.weather.parameters.edit', $parameter) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $parameters->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
