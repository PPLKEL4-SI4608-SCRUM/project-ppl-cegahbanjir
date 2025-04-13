@extends('layouts.admin')
@section('title', 'Tambah Prediksi Banjir')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tambah Prediksi Banjir</h1>
        <a href="{{ route('admin.weather.predictions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.weather.predictions.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="weather_station_id" class="form-label">Stasiun Cuaca <span class="text-danger">*</span></label>
                    <select class="form-select @error('weather_station_id') is-invalid @enderror" id="weather_station_id" name="weather_station_id" required>
                        <option value="">Pilih Stasiun Cuaca</option>
                        @foreach($stations as $station)
                            <option value="{{ $station->id }}" {{ old('weather_station_id') == $station->id ? 'selected' : '' }}>
                                {{ $station->name }} ({{ $station->location }})
                            </option>
                        @endforeach
                    </select>
                    @error('weather_station_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="prediction_date" class="form-label">Tanggal Prediksi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('prediction_date') is-invalid @enderror" id="prediction_date" name="prediction_date" value="{{ old('prediction_date') ?? now()->format('Y-m-d') }}" required>
                        @error('prediction_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="risk_level" class="form-label">Tingkat Risiko <span class="text-danger">*</span></label>
                        <select class="form-select @error('risk_level') is-invalid @enderror" id="risk_level" name="risk_level" required>
                            <option value="">Pilih Tingkat Risiko</option>
                            @foreach($riskLevels as $risk)
                                <option value="{{ $risk }}" {{ old('risk_level') == $risk ? 'selected' : '' }}>
                                    {{ ucfirst($risk) }}
                                </option>
                            @endforeach
                        </select>
                        @error('risk_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="predicted_rainfall" class="form-label">Prediksi Curah Hujan (mm)</label>
                    <input type="number" step="0.01" min="0" class="form-control @error('predicted_rainfall') is-invalid @enderror" id="predicted_rainfall" name="predicted_rainfall" value="{{ old('predicted_rainfall') }}">
                    @error('predicted_rainfall')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="notes" class="form-label">Catatan</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-light me-md-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
