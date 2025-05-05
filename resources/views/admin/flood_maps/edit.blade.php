@extends('layouts.admin')

@section('title', 'Edit Wilayah Banjir')

@section('content')
<div class="w-full max-w-2xl mx-auto bg-[#0F1A21]/80 p-8 rounded-lg shadow-lg mt-10">
    <h1 class="text-2xl font-bold text-white mb-6 text-center">Edit Wilayah Banjir</h1>

    <form method="POST" action="{{ route('admin.flood-maps.update', $floodMap) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nama Wilayah -->
        <div class="mb-6">
            <label class="block text-white mb-2">Nama Wilayah</label>
            <input type="text" name="wilayah" value="{{ $floodMap->wilayah }}"
                class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">
        </div>

        <!-- Upload Gambar -->
        <div class="mb-6">
            <label class="block text-white mb-2">Ganti Gambar</label>
            <label class="block w-full cursor-pointer bg-gray-800 text-white rounded border border-gray-600 text-center py-2 hover:border-[#FFA404] hover:text-[#FFA404]">
                Pilih Gambar
                <input type="file" name="gambar" accept="image/*" class="hidden" onchange="previewGambar(event)">
            </label>
            @if ($floodMap->gambar)
                <img id="preview" src="{{ asset('storage/' . $floodMap->gambar) }}"
                    class="mt-4 rounded shadow max-w-full max-h-[400px] mx-auto">
            @else
                <img id="preview" class="mt-4 rounded shadow max-w-full max-h-[400px] mx-auto hidden">
            @endif
        </div>

        <!-- Map -->
        <div id="map" style="height: 450px;" class="rounded shadow overflow-hidden mb-6"></div>

        <input type="hidden" name="latitude" id="latitude" value="{{ $floodMap->latitude }}">
        <input type="hidden" name="longitude" id="longitude" value="{{ $floodMap->longitude }}">

        <!-- Tombol Submit -->
        <div class="text-center">
            <button type="submit"
                class="bg-[#FFA404] hover:bg-[#ff8c00] text-white px-6 py-2 rounded transition font-semibold">
                Update
            </button>
        </div>
    </form>
</div>

<!-- Leaflet & Geocoder -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<!-- Script -->
<script>
    // Inisialisasi Leaflet Map
    const map = L.map('map').setView([{{ $floodMap->latitude }}, {{ $floodMap->longitude }}], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);
    let marker = L.marker([{{ $floodMap->latitude }}, {{ $floodMap->longitude }}]).addTo(map);

    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        document.getElementById('latitude').value = e.latlng.lat;
        document.getElementById('longitude').value = e.latlng.lng;
    });

    L.Control.geocoder({ defaultMarkGeocode: false })
        .on('markgeocode', function (e) {
            const latlng = e.geocode.center;
            marker.setLatLng(latlng);
            map.setView(latlng, 15);
            document.getElementById('latitude').value = latlng.lat;
            document.getElementById('longitude').value = latlng.lng;
        })
        .addTo(map);

    // Preview Gambar Saat Upload
    function previewGambar(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('preview');
            output.src = reader.result;
            output.classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
