@extends('layouts.admin')
@section('title', 'Edit Parameter Peringatan Banjir')
@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Edit Parameter Peringatan Banjir</h1>
        <a href="{{ route('admin.weather.parameters.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

<div class="bg-white shadow rounded-lg p-6 mb-10">
    <div class="mb-4 text-lg font-semibold text-gray-700">
        Stasiun: {{ $station->name }} ({{ $station->location }})
    </div>
    <form action="{{ route('admin.weather.parameters.update', $parameter) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="threshold_low" class="block text-sm font-medium text-gray-700">Threshold Risiko Rendah (mm) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" min="0" id="threshold_low" name="threshold_low" value="{{ old('threshold_low', $parameter->threshold_low) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('threshold_low') border-red-500 @enderror" required>
                @error('threshold_low')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Curah hujan di atas nilai ini akan dianggap berisiko rendah</p>
            </div>
            <div>
                <label for="threshold_medium" class="block text-sm font-medium text-gray-700">Threshold Risiko Sedang (mm) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" min="0" id="threshold_medium" name="threshold_medium" value="{{ old('threshold_medium', $parameter->threshold_medium) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('threshold_medium') border-red-500 @enderror" required>
                @error('threshold_medium')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Curah hujan di atas nilai ini akan dianggap berisiko sedang</p>
            </div>
            <div>
                <label for="threshold_high" class="block text-sm font-medium text-gray-700">Threshold Risiko Tinggi (mm) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" min="0" id="threshold_high" name="threshold_high" value="{{ old('threshold_high', $parameter->threshold_high) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('threshold_high') border-red-500 @enderror" required>
                @error('threshold_high')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Curah hujan di atas nilai ini akan dianggap berisiko tinggi</p>
            </div>
            <div>
                <label for="threshold_very_high" class="block text-sm font-medium text-gray-700">Threshold Risiko Sangat Tinggi (mm) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" min="0" id="threshold_very_high" name="threshold_very_high" value="{{ old('threshold_very_high', $parameter->threshold_very_high) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('threshold_very_high') border-red-500 @enderror" required>
                @error('threshold_very_high')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Curah hujan di atas nilai ini akan dianggap berisiko sangat tinggi</p>
            </div>
        </div>

        <div>
            <label for="consecutive_days" class="block text-sm font-medium text-gray-700">Jumlah Hari Berturut-turut <span class="text-red-500">*</span></label>
            <input type="number" min="1" id="consecutive_days" name="consecutive_days" value="{{ old('consecutive_days', $parameter->consecutive_days) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('consecutive_days') border-red-500 @enderror" required>
            @error('consecutive_days')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-1">Jumlah hari berturut-turut curah hujan di atas threshold untuk memicu peringatan</p>
        </div>

        <div class="flex items-center">
            <input type="checkbox" id="is_active" name="is_active" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ old('is_active', $parameter->is_active) ? 'checked' : '' }}>
            <label for="is_active" class="ml-2 block text-sm text-gray-700">Aktifkan Parameter</label>
        </div>

        <div class="flex justify-end space-x-2">
            <button type="reset" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Reset</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
