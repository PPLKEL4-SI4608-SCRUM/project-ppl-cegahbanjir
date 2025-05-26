@extends('layouts.app')

@section('title', 'Peta Rawan Banjir')

@section('content')
<div class="w-full min-h-screen">
    <div class="bg-white/80 backdrop-blur-sm max-w-6xl mx-auto px-6 py-10 mt-10 rounded-2xl shadow-xl space-y-10">

        {{-- 🌊 Judul & Search --}}
        <div class="text-center">
            <h2 class="text-3xl font-semibold mb-4 text-gray-900">Peta Rawan Banjir</h2>
            <form method="GET" action="{{ route('user.map') }}" class="flex flex-wrap justify-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama wilayah..."
                    class="px-5 py-3 rounded-full border border-gray-300 bg-white shadow w-64 text-sm placeholder-gray-500">
                <button type="submit"
                    class="px-6 py-3 rounded-full bg-[#FFA404] text-white font-semibold hover:bg-[#e59300] text-sm">
                    <i class="fas fa-search mr-1"></i> Cari
                </button>
            </form>
        </div>

        {{-- 🗺️ Map Container --}}
        <div class="bg-white/90 rounded-xl shadow-inner p-4 mx-auto max-w-4xl">
            <div id="map" class="w-full rounded-lg" style="height: 400px;"></div>
        </div>

        {{-- 📍 Daftar Wilayah dan Tingkat Rawan --}}
        @if ($maps->count())
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Titik Pantau Banjir</h3>
                @foreach ($maps as $map)
                    @php
                        $badges = [];
                        $polygonData = is_array($map->polygons) ? $map->polygons : json_decode($map->polygons, true);
                        foreach ($polygonData as $poly) {
                            $tingkat = strtolower($poly['tingkat_risiko'] ?? 'tidak diketahui');
                            $class = match ($tingkat) {
                                'sangat tinggi' => 'bg-red-600 text-white',
                                'tinggi' => 'bg-orange-400 text-white',
                                'sedang' => 'bg-yellow-300 text-gray-800',
                                'rendah' => 'bg-green-500 text-gray-800',
                                default => 'bg-gray-300 text-gray-700'
                            };
                            $badges[] = "<span class='px-3 py-1 rounded-full text-sm font-semibold {$class}'>" . ucfirst($tingkat) . "</span>";
                        }
                    @endphp
                    <div class="flex justify-between items-center border-b py-2">
                        <span class="text-gray-900 font-medium">{{ $map->wilayah }}</span>
                        <div class="flex flex-wrap gap-2">
                            {!! implode('', $badges) !!}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection

@push('styles')
    <style>
        body {
            background-image: url('{{ asset('images/background-banjir2.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
        }
    </style>
@endpush

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const map = L.map('map').setView([-6.9147, 107.6098], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const searchQuery = "{{ request('search') }}";

    fetch('/api/geojson')
        .then(res => res.json())
        .then(data => {
            const filtered = searchQuery
                ? {
                    "type": "FeatureCollection",
                    "features": data.features.filter(f =>
                        f.properties.wilayah.toLowerCase().includes(searchQuery.toLowerCase())
                    )
                }
                : data;

            if (filtered.features.length > 0) {
                const geoLayer = L.geoJson(filtered, {
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
                    onEachFeature: function (feature, layer) {
                        layer.bindPopup(`<strong>${feature.properties.wilayah}</strong><br>Tingkat: ${feature.properties.tingkat}`);
                    }
                }).addTo(map);

                map.fitBounds(geoLayer.getBounds());
            }
        });
});
</script>
@endsection
