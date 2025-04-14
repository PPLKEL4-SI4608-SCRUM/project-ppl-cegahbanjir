@extends('layouts.admin')
@section('title', 'Tambah Parameter Peringatan Banjir')
@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Tambah Parameter Peringatan Banjir</h1>
        <a href="{{ route('admin.weather.parameters.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

<div class="bg-white shadow rounded-lg p-6">
    <form action="{{ route('admin.weather.parameters.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="weather_station_id" class="block text-sm font-medium text-gray-700">Stasiun Cuaca <span class="text-red-500">*</span></label>
            <select id="weather_station_id" name="weather_station_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 text-gray-900 @error('weather_station_id') border-red-500 @enderror">
                <option value="">Pilih Stasiun Cuaca</option>
                @foreach($stationsWithoutParams as $station)
                    <option value="{{ $station->id }}" {{ old('weather_station_id') == $station->id ? 'selected' : '' }}>
                        {{ $station->name }} ({{ $station->location }})
                    </option>
                @endforeach
            </select>
            @error('weather_station_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="threshold_low" class="block text-sm font-medium text-gray-700">Threshold Risiko Rendah (mm) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" min="0" id="threshold_low" name="threshold_low" value="{{ old('threshold_low') ?? 20 }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 text-gray-900 @error('threshold_low') border-red-500 @enderror">
                @error('threshold_low')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Curah hujan di atas nilai ini akan dianggap berisiko rendah</p>
            </div>
            <div>
                <label for="threshold_medium" class="block text-sm font-medium text-gray-700">Threshold Risiko Sedang (mm) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" min="0" id="threshold_medium" name="threshold_medium" value="{{ old('threshold_medium') ?? 50 }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 text-gray-900 @error('threshold_medium') border-red-500 @enderror">
                @error('threshold_medium')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Curah hujan di atas nilai ini akan dianggap berisiko sedang</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="threshold_high" class="block text-sm font-medium text-gray-700">Threshold Risiko Tinggi (mm) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" min="0" id="threshold_high" name="threshold_high" value="{{ old('threshold_high') ?? 100 }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 text-gray-900 @error('threshold_high') border-red-500 @enderror">
                @error('threshold_high')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Curah hujan di atas nilai ini akan dianggap berisiko tinggi</p>
            </div>
            <div>
                <label for="threshold_very_high" class="block text-sm font-medium text-gray-700">Threshold Risiko Sangat Tinggi (mm) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" min="0" id="threshold_very_high" name="threshold_very_high" value="{{ old('threshold_very_high') ?? 150 }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 text-gray-900 @error('threshold_very_high') border-red-500 @enderror">
                @error('threshold_very_high')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Curah hujan di atas nilai ini akan dianggap berisiko sangat tinggi</p>
            </div>
        </div>

        <div class="mb-4">
            <label for="consecutive_days" class="block text-sm font-medium text-gray-700">Jumlah Hari Berturut-turut <span class="text-red-500">*</span></label>
            <input type="number" min="1" id="consecutive_days" name="consecutive_days" value="{{ old('consecutive_days') ?? 1 }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 text-gray-900 @error('consecutive_days') border-red-500 @enderror">
            @error('consecutive_days')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-1">Jumlah hari berturut-turut curah hujan di atas threshold untuk memicu peringatan</p>
        </div>

        <div class="mb-4 flex items-center">
            <input type="checkbox" id="is_active" name="is_active" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ old('is_active') ? 'checked' : 'checked' }}>
            <label for="is_active" class="ml-2 block text-sm text-gray-700">Aktifkan Parameter</label>
        </div>

        <div class="flex justify-end space-x-2">
            <button type="reset" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">Reset</button>
            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#f97316] rounded hover:bg-[#ea580c]">Simpan</button>
        </div>
    </form>
</div>
@endsection
