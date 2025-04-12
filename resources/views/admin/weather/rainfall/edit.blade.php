@extends('layouts.admin')

@section('title', 'Edit Data Curah Hujan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Data Curah Hujan</h1>
        <a href="{{ route('admin.weather.rainfall.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.weather.rainfall.update', $rainfall) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="weather_station_id" class="form-label">Stasiun Cuaca <span class="text-danger">*</span></label>
                    <select class="form-select @error('weather_station_id') is-invalid @enderror" id="weather_station_id" name="weather_station_id" required>
                        <option value="">Pilih Stasiun Cuaca</option>
                        @foreach($stations as $station)
                            <option value="{{ $station->id }}" {{ old('weather_station_id', $rainfall->weather_station_id) == $station->id ? 'selected' : '' }}>
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
                        <label for="recorded_at" class="form-label">Tanggal dan Waktu <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('recorded_at') is-invalid @enderror" id="recorded_at" name="recorded_at" value="{{ old('recorded_at', $rainfall->recorded_at->format('Y-m-d\TH:i')) }}" required>
                        @error('recorded_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="data_source" class="form-label">Sumber Data <span class="text-danger">*</span></label>
                        <select class="form-select @error('data_source') is-invalid @enderror" id="data_source" name="data_source" required>
                            <option value="manual" {{ old('data_source', $rainfall->data_source) == 'manual' ? 'selected' : '' }}>Manual</option>
                            <option value="api" {{ old('data_source', $rainfall->data_source) == 'api' ? 'selected' : '' }}>API</option>
                            <option value="sensor" {{ old('data_source', $rainfall->data_source) == 'sensor' ? 'selected' : '' }}>Sensor</option>
                        </select>
                        @error('data_source')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="rainfall_amount" class="form-label">Curah Hujan (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control @error('rainfall_amount') is-invalid @enderror" id="rainfall_amount" name="rainfall_amount" value="{{ old('rainfall_amount', $rainfall->rainfall_amount) }}" required>
                        @error('rainfall_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="intensity" class="form-label">Intensitas (mm/jam)</label>
                        <input type="number" step="0.01" min="0" class="form-control @error('intensity') is-invalid @enderror" id="intensity" name="intensity" value="{{ old('intensity', $rainfall->intensity) }}">
                        @error('intensity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Opsional. Akan dihitung otomatis jika tidak diisi.</div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-light me-md-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection