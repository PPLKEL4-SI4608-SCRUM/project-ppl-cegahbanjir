@extends('layouts.admin')

@section('title', 'Edit Wilayah Rawan Banjir')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-[#0F1A21]/80 rounded text-white mt-10">
    <h1 class="text-2xl font-semibold mb-6 text-center">Edit Wilayah Rawan Banjir</h1>

    <form method="POST" action="{{ route('admin.flood-maps.update', $floodMap) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label>Nama Wilayah</label>
            <input type="text" name="wilayah" value="{{ old('wilayah', $floodMap->wilayah) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600">
        </div>

        <div class="mb-4">
            <label>Tingkat Risiko Wilayah Banjir (Untuk Polygon Baru)</label>
            <select id="risk_for_polygon" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">
                <option value="rendah">Rendah</option>
                <option value="sedang">Sedang</option>
                <option value="tinggi">Tinggi</option>
                <option value="sangat tinggi">Sangat Tinggi</option>
            </select>
        </div>

        <input type="hidden" name="polygons" id="polygons">

        <div id="map" style="height: 400px;" class="rounded shadow mb-6 z-0"></div>

        <button type="submit" class="bg-[#FFA404] px-6 py-2 rounded">Update</button>
    </form>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<style>
    .leaflet-control-geocoder-form {
        background-color: #1F2937 !important;
        border: 1px solid #4B5563 !important;
        color: #F9FAFB !important;
    }
    .leaflet-control-geocoder-form input {
        background-color: #1F2937 !important;
        color: #F9FAFB !important;
        border: none !important;
    }
    .leaflet-control-geocoder-form input::placeholder {
        color: #9CA3AF !important;
    }
    .leaflet-control-geocoder-icon,
    .leaflet-control-geocoder-form button {
        filter: brightness(90%);
    }
</style>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    const map = L.map('map').setView([-6.9147, 107.6098], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const drawnItems = new L.FeatureGroup().addTo(map);
    const polygonData = [];

    const colorMap = {
        "rendah": "#FED976",
        "sedang": "#E31A1C",
        "tinggi": "#BD0026",
        "sangat tinggi": "#800026"
    };

    let existing = {!! json_encode($floodMap->polygons ?? []) !!};
    if (typeof existing === 'string') {
        try {
            existing = JSON.parse(existing);
        } catch (e) {
            existing = [];
        }
    }

    if (Array.isArray(existing)) {
        existing.forEach(p => {
            const latlngs = p.coordinates.map(c => [c[1], c[0]]);
            const layer = L.polygon(latlngs, {
                color: colorMap[p.tingkat_risiko] || '#2563EB'
            }).addTo(drawnItems);
            layer.feature = { properties: { tingkat_risiko: p.tingkat_risiko } };
            polygonData.push(p);
        });
        map.fitBounds(drawnItems.getBounds());
    }

    const drawControl = new L.Control.Draw({
        draw: {
            polygon: true,
            marker: false,
            circle: false,
            rectangle: false,
            polyline: false,
            circlemarker: false
        },
        edit: {
            featureGroup: drawnItems,
            remove: true
        }
    });
    map.addControl(drawControl);

    function syncPolygons() {
        const layers = drawnItems.getLayers();
        const updated = [];
        layers.forEach(l => {
            const coords = l.getLatLngs()[0].map(latlng => [latlng.lng, latlng.lat]);
            const risiko = l.feature?.properties?.tingkat_risiko || document.getElementById('risk_for_polygon').value || 'rendah';
            updated.push({ coordinates: coords, tingkat_risiko: risiko });
        });
        polygonData.length = 0;
        polygonData.push(...updated);
        document.getElementById('polygons').value = JSON.stringify(polygonData);
    }

    map.on(L.Draw.Event.CREATED, function (e) {
        const layer = e.layer;
        const coords = layer.getLatLngs()[0].map(latlng => [latlng.lng, latlng.lat]);
        const risiko = document.getElementById('risk_for_polygon').value;
        layer.setStyle({ color: colorMap[risiko] || '#2563EB' });
        layer.feature = { properties: { tingkat_risiko: risiko } };
        drawnItems.addLayer(layer);
        polygonData.push({ coordinates: coords, tingkat_risiko: risiko });
        document.getElementById('polygons').value = JSON.stringify(polygonData);
    });

    map.on(L.Draw.Event.EDITED, syncPolygons);
    map.on(L.Draw.Event.DELETED, syncPolygons);
    window.addEventListener('load', syncPolygons);

    L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        const bbox = e.geocode.bbox;
        const bounds = [[bbox.getSouth(), bbox.getWest()], [bbox.getNorth(), bbox.getEast()]];
        map.fitBounds(bounds);
        L.marker(e.geocode.center).addTo(map).bindPopup(e.geocode.name).openPopup();
    })
    .addTo(map);
</script>
@endsection
