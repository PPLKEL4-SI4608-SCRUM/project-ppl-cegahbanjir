@extends('layouts.app')

@section('title', 'Peta Rawan Banjir')

@section('content')
<div class="relative w-full min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/background-banjir2.png') }}')">
    <div class="bg-[#0F1A21]/80 w-full h-full py-16 px-4">
        <h1 class="text-3xl font-bold text-white text-center mb-6">Peta Rawan Banjir</h1>

        <form method="GET" action="{{ route('user.map') }}" class="flex justify-center mb-6">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama wilayah..."
                class="rounded-l-full bg-gray-800 text-white px-6 py-2 w-72 placeholder-gray-400">
            <button type="submit"
                class="bg-[#FFA404] text-white px-6 py-2 rounded-r-full hover:bg-[#ff8c00]">
                Cari
            </button>
        </form>

        <div id="map" class="mx-auto rounded shadow" style="height: 500px; max-width: 90%;"></div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    const map = L.map('map').setView([-6.9147, 107.6098], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    fetch('/api/geojson')
        .then(res => res.json())
        .then(data => {
            L.geoJson(data, {
                style: feature => {
                    const colorMap = {
                        'sangat tinggi': '#800026',
                        'tinggi': '#BD0026',
                        'sedang': '#E31A1C',
                        'rendah': '#FED976'
                    };
                    return {
                        fillColor: colorMap[feature.properties.tingkat] || '#FFEDA0',
                        weight: 1,
                        color: 'white',
                        fillOpacity: 0.6
                    };
                },
                onEachFeature: function(feature, layer) {
                    layer.bindPopup(`<strong>${feature.properties.wilayah}</strong><br>Tingkat: ${feature.properties.tingkat}`);
                }
            }).addTo(map);
        });
</script>
@endsection
