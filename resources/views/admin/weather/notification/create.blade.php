@extends('layouts.admin')

@section('title', 'Buat Notifikasi')

@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Buat Notifikasi</h1>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
            <i class="fas fa-arrow-left mr-2 text-gray-700"></i> Kembali
        </a>
    </div>

<div class="bg-white shadow rounded-lg p-6">
    <form action="{{ route('admin.weather.notification.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="weather_station_id" class="block text-sm font-medium text-gray-700">Lokasi<span class="text-red-500">*</span></label>
            <select id="weather_station_id" name="weather_station_id" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('weather_station_id') border-red-500 @enderror">
                <option value="">Pilih Lokasi</option>
                @foreach($weatherStations as $station)
                    <option value="{{ $station->id }}" {{ old('weather_station_id') == $station->id ? 'selected' : '' }}>
                        {{ $station->name }} - ({{ $station->location }})
                    </option>
                @endforeach
            </select>
            @error('weather_station_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 text-xs text-white bg-yellow-600 rounded hover:bg-yellow-700">
                    Kirim Notifikasi
                </button>
            </div>
    </form>
</div>
@endsection
