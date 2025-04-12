@extends('layouts.admin')

@section('title', 'Manajemen Data Curah Hujan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manajemen Data Curah Hujan</h1>
        <a href="{{ route('admin.weather.rainfall.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Data
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($rainfallData->isEmpty())
                <div class="alert alert-info">
                    Belum ada data curah hujan yang tersedia. Silakan tambahkan data baru.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Stasiun</th>
                                <th>Tanggal & Waktu</th>
                                <th>Curah Hujan (mm)</th>
                                <th>Intensitas (mm/jam)</th>
                                <th>Sumber Data</th>
                                <th>Ditambahkan Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rainfallData as $data)
                                <tr>
                                    <td>{{ $data->weatherStation->name }}</td>
                                    <td>{{ $data->recorded_at->format('d M Y H:i') }}</td>
                                    <td>{{ $data->rainfall_amount }}</td>
                                    <td>{{ $data->intensity ?? '-' }}</td>
                                    <td>
                                        @if($data->data_source == 'manual')
                                            <span class="badge bg-secondary">Manual</span>
                                        @elseif($data->data_source == 'api')
                                            <span class="badge bg-info">API</span>
                                        @else
                                            <span class="badge bg-primary">Sensor</span>
                                        @endif
                                    </td>
                                    <td>{{ $data->addedBy->name }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.weather.rainfall.edit', $data) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.weather.rainfall.destroy', $data) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                    {{ $rainfallData->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
