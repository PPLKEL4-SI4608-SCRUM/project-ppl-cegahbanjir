@extends('layouts.admin')

@section('title', 'Edit Prediksi Banjir')

@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Prediksi Banjir</h1>
        <a href="{{ route('admin.weather.predictions.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

<div class="bg-white shadow rounded-lg p-6 mb-10">
    <form action="{{ route('admin.weather.predictions.update', $prediction) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="weather_station_id" class="block text-sm font-medium text-gray-700">Stasiun Cuaca <span class="text-red-500">*</span></label>
            <select id="weather_station_id" name="weather_station_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('weather_station_id') border-red-500 @enderror">
                <option value="">Pilih Stasiun Cuaca</option>
                @foreach($stations as $station)
                    <option value="{{ $station->id }}" {{ old('weather_station_id', $prediction->weather_station_id) == $station->id ? 'selected' : '' }}>
                        {{ $station->name }} ({{ $station->location }})
                    </option>
                @endforeach
            </select>
            @error('weather_station_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="prediction_date" class="block text-sm font-medium text-gray-700">Tanggal Prediksi <span class="text-red-500">*</span></label>
                <input type="date" id="prediction_date" name="prediction_date" required value="{{ old('prediction_date', $prediction->prediction_date->format('Y-m-d')) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('prediction_date') border-red-500 @enderror">
                @error('prediction_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="risk_level" class="block text-sm font-medium text-gray-700">Tingkat Risiko <span class="text-red-500">*</span></label>
                <select id="risk_level" name="risk_level" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('risk_level') border-red-500 @enderror">
                    <option value="">Pilih Tingkat Risiko</option>
                    @foreach($riskLevels as $risk)
                        <option value="{{ $risk }}" {{ old('risk_level', $prediction->risk_level) == $risk ? 'selected' : '' }}>{{ ucfirst($risk) }}</option>
                    @endforeach
                </select>
                @error('risk_level')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="predicted_rainfall" class="block text-sm font-medium text-gray-700">Prediksi Curah Hujan (mm)</label>
            <input type="number" step="0.01" min="0" id="predicted_rainfall" name="predicted_rainfall" value="{{ old('predicted_rainfall', $prediction->predicted_rainfall) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('predicted_rainfall') border-red-500 @enderror">
            @error('predicted_rainfall')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
            <textarea id="notes" name="notes" rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('notes') border-red-500 @enderror">{{ old('notes', $prediction->notes) }}</textarea>
            @error('notes')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-2">
            <button type="reset" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">Reset</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
