@extends('layouts.admin')
@section('title', 'Edit Parameter Peringatan Banjir')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Parameter Peringatan Banjir</h1>
        <a href="{{ route('admin.weather.parameters.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Stasiun: {{ $station->name }} ({{ $station->location }})</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.weather.parameters.update', $parameter) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="threshold_low" class="form-label">Threshold Risiko Rendah (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control @error('threshold_low') is-invalid @enderror" id="threshold_low" name="threshold_low" value="{{ old('threshold_low', $parameter->threshold_low) }}" required>
                        @error('threshold_low')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Curah hujan di atas nilai ini akan dianggap berisiko rendah</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="threshold_medium" class="form-label">Threshold Risiko Sedang (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control @error('threshold_medium') is-invalid @enderror" id="threshold_medium" name="threshold_medium" value="{{ old('threshold_medium', $parameter->threshold_medium) }}" required>
                        @error('threshold_medium')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Curah hujan di atas nilai ini akan dianggap berisiko sedang</div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="threshold_high" class="form-label">Threshold Risiko Tinggi (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control @error('threshold_high') is-invalid @enderror" id="threshold_high" name="threshold_high" value="{{ old('threshold_high', $parameter->threshold_high) }}" required>
                        @error('threshold_high')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Curah hujan di atas nilai ini akan dianggap berisiko tinggi</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="threshold_very_high" class="form-label">Threshold Risiko Sangat Tinggi (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control @error('threshold_very_high') is-invalid @enderror" id="threshold_very_high" name="threshold_very_high" value="{{ old('threshold_very_high', $parameter->threshold_very_high) }}" required>
                        @error('threshold_very_high')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Curah hujan di atas nilai ini akan dianggap berisiko sangat tinggi</div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="consecutive_days" class="form-label">Jumlah Hari Berturut-turut <span class="text-danger">*</span></label>
                    <input type="number" min="1" class="form-control @error('consecutive_days') is-invalid @enderror" id="consecutive_days" name="consecutive_days" value="{{ old('consecutive_days', $parameter->consecutive_days) }}" required>
                    @error('consecutive_days')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Jumlah hari berturut-turut curah hujan di atas threshold untuk memicu peringatan</div>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', $parameter->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktifkan Parameter</label>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-light me-md-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection