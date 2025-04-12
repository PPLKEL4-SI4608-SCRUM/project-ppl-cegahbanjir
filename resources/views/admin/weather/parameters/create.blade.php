@extends('layouts.admin')
@section('title', 'Tambah Parameter Peringatan Banjir')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tambah Parameter Peringatan Banjir</h1>
        <a href="{{ route('admin.weather.parameters.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.weather.parameters.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="weather_station_id" class="form-label">Stasiun Cuaca <span class="text-danger">*</span></label>
                    <select class="form-select @error('weather_station_id') is-invalid @enderror" id="weather_station_id" name="weather_station_id" required>
                        <option value="">Pilih Stasiun Cuaca</option>
                        @foreach($stationsWithoutParams as $station)
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
                        <label for="threshold_low" class="form-label">Threshold Risiko Rendah (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control @error('threshold_low') is-invalid @enderror" id="threshold_low" name="threshold_low" value="{{ old('threshold_low') ?? 20 }}" required>
                        @error('threshold_low')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Curah hujan di atas nilai ini akan dianggap berisiko rendah</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="threshold_medium" class="form-label">Threshold Risiko Sedang (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control @error('threshold_medium') is-invalid @enderror" id="threshold_medium" name="threshold_medium" value="{{ old('threshold_medium') ?? 50 }}" required>
                        @error('threshold_medium')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Curah hujan di atas nilai ini akan dianggap berisiko sedang</div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="threshold_high" class="form-label">Threshold Risiko Tinggi (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control @error('threshold_high') is-invalid @enderror" id="threshold_high" name="threshold_high" value="{{ old('threshold_high') ?? 100 }}" required>
                        @error('threshold_high')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Curah hujan di atas nilai ini akan dianggap berisiko tinggi</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="threshold_very_high" class="form-label">Threshold Risiko Sangat Tinggi (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control @error('threshold_very_high') is-invalid @enderror" id="threshold_very_high" name="threshold_very_high" value="{{ old('threshold_very_high') ?? 150 }}" required>
                        @error('threshold_very_high')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Curah hujan di atas nilai ini akan dianggap berisiko sangat tinggi</div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="consecutive_days" class="form-label">Jumlah Hari Berturut-turut <span class="text-danger">*</span></label>
                    <input type="number" min="1" class="form-control @error('consecutive_days') is-invalid @enderror" id="consecutive_days" name="consecutive_days" value="{{ old('consecutive_days') ?? 1 }}" required>
                    @error('consecutive_days')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Jumlah hari berturut-turut curah hujan di atas threshold untuk memicu peringatan</div>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active') ? 'checked' : 'checked' }}>
                    <label class="form-check-label" for="is_active">Aktifkan Parameter</label>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-light me-md-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection