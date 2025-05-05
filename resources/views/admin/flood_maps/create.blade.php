@extends('layouts.admin')

@section('title', 'Tambah Wilayah Banjir')

@section('content')
<div class="w-full max-w-2xl mx-auto bg-[#0F1A21]/80 p-8 rounded-lg shadow-lg mt-10">
    <h1 class="text-2xl font-bold text-white mb-6 text-center">Tambah Wilayah Banjir</h1>

    <form method="POST" action="{{ route('admin.flood-maps.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Nama Wilayah -->
        <div class="mb-6">
            <label class="block text-white mb-2">Nama Wilayah</label>
            <input type="text" name="wilayah" required placeholder="Contoh: Cangkuang Wetan, Sukabirus"
                class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white placeholder-gray-400">
        </div>

        <!-- Upload Gambar -->
        <div class="mb-6">
            <label class="block text-white mb-2">Upload Gambar</label>
            <label class="block w-full cursor-pointer bg-gray-800 text-white rounded border border-gray-600 text-center py-2 hover:border-[#FFA404] hover:text-[#FFA404]">
                Pilih Gambar
                <input type="file" name="gambar" accept="image/*" class="hidden" onchange="previewGambar(event)">
            </label>
            <img id="preview" class="mt-4 rounded shadow max-w-full max-h-[400px] mx-auto hidden">
        </div>

        <!-- Peta -->
        <div class="mb-6">
            <label class="block text-white mb-2">Pilih Lokasi di Peta atau Cari Lokasi</label>
            <div id="map" style="height: 450px;" class="rounded shadow overflow-hidden"></div>
        </div>

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <!-- Tombol Simpan -->
        <div class="text-center">
            <button type="submit"
                class="bg-[#FFA404] hover:bg-[#ff8c00] text-white px-6 py-2 rounded transition font-semibold">
                Simpan
            </button>
        </div>
    </form>
</div>

<!-- Leaflet Assets -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<!-- Input Search Style Fix -->
<style>
    .leaflet-control-geocoder-form input {
        color: black !important;
        background-color: white !important;
    }
</style>

<!-- Script Map & Preview -->
<script>
    const map = L.map('map').setView([-6.9147, 107.6098], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    let marker;

    map.on('click', function (e) {
        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }
        document.getElementById('latitude').value = e.latlng.lat;
        document.getElementById('longitude').value = e.latlng.lng;
    });

    L.Control.geocoder({ defaultMarkGeocode: false })
        .on('markgeocode', function (e) {
            const latlng = e.geocode.center;
            if (marker) {
                marker.setLatLng(latlng);
            } else {
                marker = L.marker(latlng).addTo(map);
            }
            map.setView(latlng, 15);
            document.getElementById('latitude').value = latlng.lat;
            document.getElementById('longitude').value = latlng.lng;
        })
        .addTo(map);

    // Preview Gambar
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
