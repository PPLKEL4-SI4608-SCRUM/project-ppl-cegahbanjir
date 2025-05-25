@extends('layouts.admin')

@section('title', 'Tambah Stasiun Cuaca')

@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Tambah Stasiun Cuaca</h1>
        <a href="{{ route('admin.weather.stations.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
            <i class="fas fa-arrow-left mr-2 text-gray-700"></i> Kembali
        </a>
    </div>

<div class="bg-white shadow rounded-lg p-6">
    <form action="{{ route('admin.weather.stations.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Stasiun <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <label for="location" class="block text-sm font-medium text-gray-700">Lokasi <span class="text-red-500">*</span></label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" required
                    autocomplete="off"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('location') border-red-500 @enderror">
                @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude <span class="text-red-500">*</span></label>
                <input type="number" step="any" id="latitude" name="latitude" value="{{ old('latitude') }}" required
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('latitude') border-red-500 @enderror">
                <p class="text-sm text-gray-500">Contoh: -6.2088 (Jakarta)</p>
                @error('latitude')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude <span class="text-red-500">*</span></label>
                <input type="number" step="any" id="longitude" name="longitude" value="{{ old('longitude') }}" required
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('longitude') border-red-500 @enderror">
                <p class="text-sm text-gray-500">Contoh: 106.8456 (Jakarta)</p>
                @error('longitude')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
            <select id="status" name="status" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('status') border-red-500 @enderror">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Pemeliharaan</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-2">
            <button type="reset" class="px-4 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-200">Reset</button>
            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#f97316] rounded hover:bg-[#ea580c]">Simpan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const locationInput = document.getElementById('location');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        let timeout = null;

        locationInput.addEventListener('input', function () {
            const query = this.value;

            if (timeout) clearTimeout(timeout);

            timeout = setTimeout(() => {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&addressdetails=1&limit=5`)
                    .then(response => response.json())
                    .then(results => {
                        let dropdown = document.getElementById('location-suggestions');
                        if (!dropdown) {
                            dropdown = document.createElement('div');
                            dropdown.id = 'location-suggestions';
                            dropdown.classList.add('bg-white', 'border', 'rounded', 'absolute', 'z-10', 'w-full', 'max-h-60', 'overflow-y-auto', 'shadow');
                            locationInput.parentNode.appendChild(dropdown);
                        }
                        dropdown.innerHTML = '';
                        results.forEach(place => {
                            const option = document.createElement('div');
                            option.textContent = place.display_name;
                            option.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-100', 'text-black');
                            option.addEventListener('click', () => {
                                locationInput.value = place.display_name;
                                latitudeInput.value = place.lat;
                                longitudeInput.value = place.lon;
                                dropdown.innerHTML = '';
                            });
                            dropdown.appendChild(option);
                        });
                    });
            }, 400);
        });

        // Klik di luar dropdown untuk menghilangkan saran
        document.addEventListener('click', function (e) {
            const dropdown = document.getElementById('location-suggestions');
            if (dropdown && !locationInput.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.innerHTML = '';
            }
        });
    });
</script>
@endpush
