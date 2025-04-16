@extends('layouts.admin')

@section('title', 'Tambah Data Curah Hujan')

@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Tambah Data Curah Hujan</h1>
        <a href="{{ route('admin.weather.rainfall.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
            <i class="fas fa-arrow-left mr-2 text-gray-700"></i> Kembali
        </a>
    </div>

<div class="bg-white shadow rounded-lg p-6">
    <form action="{{ route('admin.weather.rainfall.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="weather_station_id" class="block text-sm font-medium text-gray-700">Stasiun Cuaca <span class="text-red-500">*</span></label>
            <select id="weather_station_id" name="weather_station_id" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('weather_station_id') border-red-500 @enderror">
                <option value="">Pilih Stasiun Cuaca</option>
                @foreach($stations as $station)
                    <option value="{{ $station->id }}" {{ old('weather_station_id') == $station->id ? 'selected' : '' }}>
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
                <label for="recorded_at" class="block text-sm font-medium text-gray-700">Tanggal dan Waktu <span class="text-red-500">*</span></label>
                <input type="datetime-local" id="recorded_at" name="recorded_at" required value="{{ old('recorded_at') ?? now()->format('Y-m-d\TH:i') }}"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('recorded_at') border-red-500 @enderror">
                @error('recorded_at')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="data_source" class="block text-sm font-medium text-gray-700">Sumber Data <span class="text-red-500">*</span></label>
                <select id="data_source" name="data_source" required
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('data_source') border-red-500 @enderror">
                    <option value="manual" {{ old('data_source') == 'manual' ? 'selected' : '' }}>Manual</option>
                    <option value="api" {{ old('data_source') == 'api' ? 'selected' : '' }}>API</option>
                    <option value="sensor" {{ old('data_source') == 'sensor' ? 'selected' : '' }}>Sensor</option>
                </select>
                @error('data_source')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="rainfall_amount" class="block text-sm font-medium text-gray-700">Curah Hujan (mm) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" min="0" id="rainfall_amount" name="rainfall_amount" required
                    value="{{ old('rainfall_amount') }}"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('rainfall_amount') border-red-500 @enderror">
                @error('rainfall_amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="intensity" class="block text-sm font-medium text-gray-700">Intensitas (mm/jam)</label>
                <input type="number" step="0.01" min="0" id="intensity" name="intensity"
                    value="{{ old('intensity') }}"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('intensity') border-red-500 @enderror">
                @error('intensity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Opsional. Akan dihitung otomatis jika tidak diisi.</p>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <button type="reset" class="px-4 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-200">Reset</button>
            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#f97316] rounded hover:bg-[#ea580c]">Simpan</button>
        </div>
    </form>
</div>
@endsection
