@extends('layouts.admin')

@section('title', 'Tambah Wilayah Rawan Banjir')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-[#0F1A21]/80 rounded text-white mt-10">
    <h1 class="text-2xl font-semibold mb-6 text-center">Tambah Wilayah Rawan Banjir</h1>

    <form method="POST" action="{{ route('admin.flood-maps.store') }}">
        @csrf

        <div class="mb-4">
            <label>Nama Wilayah</label>
            <input type="text" name="wilayah" class="w-full p-2 rounded bg-gray-800 border border-gray-600">
        </div>

        <div class="mb-4">
            <label>Tingkat Risiko</label>
            <select name="tingkat_risiko" class="w-full p-2 rounded bg-gray-800 border border-gray-600">
                <option value="rendah">Rendah</option>
                <option value="sedang">Sedang</option>
                <option value="tinggi">Tinggi</option>
                <option value="sangat tinggi">Sangat Tinggi</option>
            </select>
        </div>

        <input type="hidden" name="polygon_coordinates" id="polygon_coordinates">

        <div id="map" style="height: 400px;" class="rounded shadow mb-6"></div>

        <button type="submit" class="bg-[#FFA404] px-6 py-2 rounded">Simpan</button>
    </form>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>

<script>
    const map = L.map('map').setView([-6.9147, 107.6098], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    const drawnItems = new L.FeatureGroup().addTo(map);
    const drawControl = new L.Control.Draw({
        draw: { polygon: true, marker: false, circle: false, polyline: false, rectangle: false },
        edit: { featureGroup: drawnItems }
    });
    map.addControl(drawControl);

    map.on(L.Draw.Event.CREATED, function (e) {
        drawnItems.clearLayers();
        drawnItems.addLayer(e.layer);
        const coordinates = e.layer.getLatLngs()[0].map(latlng => [latlng.lng, latlng.lat]);
        document.getElementById('polygon_coordinates').value = JSON.stringify(coordinates);
    });
</script>
@endsection
