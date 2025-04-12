@extends('layouts.admin')
@section('title', 'Manajemen Prediksi Banjir')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manajemen Prediksi Banjir</h1>
        <a href="{{ route('admin.weather.predictions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Prediksi
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            @if($predictions->isEmpty())
                <div class="alert alert-info">
                    Belum ada data prediksi banjir. Silakan tambahkan prediksi baru.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Stasiun</th>
                                <th>Tanggal Prediksi</th>
                                <th>Tingkat Risiko</th>
                                <th>Prediksi Curah Hujan</th>
                                <th>Dibuat Oleh</th>
                                <th>Dibuat Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($predictions as $prediction)
                                <tr>
                                    <td>{{ $prediction->weatherStation->name }}</td>
                                    <td>{{ $prediction->prediction_date->format('d M Y') }}</td>
                                    <td>
                                        @if($prediction->risk_level == 'rendah')
                                            <span class="badge bg-success">Rendah</span>
                                        @elseif($prediction->risk_level == 'sedang')
                                            <span class="badge bg-warning">Sedang</span>
                                        @elseif($prediction->risk_level == 'tinggi')
                                            <span class="badge bg-danger">Tinggi</span>
                                        @else
                                            <span class="badge bg-dark">Sangat Tinggi</span>
                                        @endif
                                    </td>
                                    <td>{{ $prediction->predicted_rainfall ?? '-' }} mm</td>
                                    <td>{{ $prediction->createdBy->name }}</td>
                                    <td>{{ $prediction->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.weather.predictions.edit', $prediction) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.weather.predictions.destroy', $prediction) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus prediksi ini?')">
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
                    {{ $predictions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection