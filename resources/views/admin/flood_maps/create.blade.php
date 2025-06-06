@extends('layouts.admin')

@section('title', 'Tambah Wilayah Rawan Banjir')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white/60 backdrop-blur-md rounded-2xl text-[#0F1A21] mt-10 shadow-xl">

    <h1 class="text-2xl font-bold mb-6 text-center">Tambah Wilayah Rawan Banjir</h1>

    <form method="GET" action="{{ route('admin.flood-maps.create') }}" class="mb-6">
        <label class="block font-semibold mb-1">Pilih Stasiun Cuaca</label>
        <div class="flex gap-2">
            <select name="station_id" class="w-full p-2 rounded border border-gray-300 bg-gray-100 text-[#0F1A21]" required>
                <option value="">-- Pilih Stasiun --</option>
                @foreach($stations as $station)
                    <option value="{{ $station->id }}" @if($selectedStation == $station->id) selected @endif>
                        {{ $station->location }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded font-medium">
                Tampilkan
            </button>
        </div>
    </form>

    @if($rainfalls->count())
        <div class="mb-6 p-4 bg-white rounded-xl shadow border border-gray-200">
            <h2 class="text-lg font-semibold mb-4">Data Curah Hujan - Hari Ini</h2>
            <table class="w-full text-sm table-auto border border-gray-200 rounded-xl overflow-hidden">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Curah Hujan</th>
                        <th class="px-4 py-2">Intensitas</th>
                        <th class="px-4 py-2">Sumber</th>
                        <th class="px-4 py-2">Kategori</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($rainfalls as $r)
                        @php
                            $kategoriColor = match($r->category) {
                                'rendah' => 'bg-green-500',
                                'sedang' => 'bg-yellow-400',
                                'tinggi' => 'bg-orange-500',
                                'sangat tinggi' => 'bg-red-600',
                                default => 'bg-gray-500',
                            };
                        @endphp
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($r->date)->format('d M Y') }}</td>
                            <td class="px-4 py-2">{{ number_format($r->rainfall_amount, 2) }} mm</td>
                            <td class="px-4 py-2">{{ number_format($r->intensity, 2) }} mm/jam</td>
                            <td class="px-4 py-2">
                                <span class="inline-block text-xs px-2 py-1 rounded text-white
                                    @if($r->data_source == 'api') bg-green-500
                                    @elseif($r->data_source == 'sensor') bg-blue-500
                                    @else bg-gray-500 @endif">
                                    {{ ucfirst($r->data_source) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="inline-block text-xs px-3 py-1 text-white rounded {{ $kategoriColor }}">
                                    {{ ucfirst($r->category) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.flood-maps.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block font-medium mb-1">Nama Wilayah</label>
            <select name="wilayah" id="wilayah_select" class="w-full p-2 rounded bg-gray-100 border border-gray-300 text-[#0F1A21]" required>
                <option value="">-- Pilih Wilayah --</option>
                @foreach ($stations as $station)
                    <option value="{{ $station->location }}"
                            data-lat="{{ $station->latitude }}"
                            data-lng="{{ $station->longitude }}"
                            {{ old('wilayah') == $station->location ? 'selected' : '' }}>
                        {{ $station->location }}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="mb-4">
            <label class="block font-medium mb-1">Tingkat Risiko Wilayah Banjir (Untuk Polygon Baru)</label>
            <select id="risk_for_polygon" class="w-full p-2 rounded bg-gray-100 border border-gray-300 text-[#0F1A21]">
                <option value="rendah">Rendah</option>
                <option value="sedang">Sedang</option>
                <option value="tinggi">Tinggi</option>
                <option value="sangat tinggi">Sangat Tinggi</option>
            </select>
        </div>

        <input type="hidden" name="polygons" id="polygons">

        <div id="map" style="height: 400px;" class="rounded shadow mb-6 z-0"></div>

        <button type="submit" class="bg-[#FFA404] hover:bg-[#e89402] px-6 py-2 rounded text-white font-semibold transition">
            Simpan
        </button>
    </form>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    const map = L.map('map').setView([-6.9147, 107.6098], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let currentWilayahMarker = null;

    L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        // Remove any existing marker if geocoder is used
        if (currentWilayahMarker) {
            map.removeLayer(currentWilayahMarker);
            currentWilayahMarker = null;
        }

        const bbox = e.geocode.bbox;
        const bounds = [[bbox.getSouth(), bbox.getWest()], [bbox.getNorth(), bbox.getEast()]];
        map.fitBounds(bounds); // This will zoom and center based on the bounding box of the search result

        currentWilayahMarker = L.marker(e.geocode.center).addTo(map)
            .bindPopup(e.geocode.name)
            .openPopup();
    })
    .addTo(map);

    const drawnItems = new L.FeatureGroup().addTo(map);
    const polygonData = [];

    const colorMap = {
        "rendah": "#FED976",
        "sedang": "#FD8D3C",
        "tinggi": "#E31A1C",
        "sangat tinggi": "#BD0026"
    };

    const drawControl = new L.Control.Draw({
        draw: {
            polygon: {
                allowIntersection: false,
                drawError: {
                    color: '#e1e100',
                    message: '<strong>Error:</strong> Polygon cannot intersect itself!'
                },
                shapeOptions: {
                    color: '#2563EB',
                    fillOpacity: 0.5
                }
            },
            marker: false,
            circle: false,
            polyline: false,
            rectangle: false,
            circlemarker: false
        },
        edit: {
            featureGroup: drawnItems,
            remove: true
        }
    });
    map.addControl(drawControl);

    map.on(L.Draw.Event.CREATED, function (e) {
        const layer = e.layer;
        const coords = layer.getLatLngs()[0].map(latlng => [latlng.lng, latlng.lat]);
        const risiko = document.getElementById('risk_for_polygon').value;

        layer.setStyle({ color: colorMap[risiko] || '#2563EB', fillColor: colorMap[risiko] || '#2563EB', fillOpacity: 0.5 });
        layer.feature = { properties: { tingkat_risiko: risiko } };

        drawnItems.addLayer(layer);
        polygonData.push({ coordinates: coords, tingkat_risiko: risiko });

        document.getElementById('polygons').value = JSON.stringify(polygonData);
    });

    map.on(L.Draw.Event.EDITED, function () {
        const updated = drawnItems.getLayers().map(l => {
            const coords = l.getLatLngs()[0].map(latlng => [latlng.lng, latlng.lat]);
            const risiko = l.feature?.properties?.tingkat_risiko || 'rendah';
            return { coordinates: coords, tingkat_risiko: risiko };
        });

        polygonData.length = 0;
        polygonData.push(...updated);
        document.getElementById('polygons').value = JSON.stringify(polygonData);
    });

    map.on(L.Draw.Event.DELETED, function () {
        polygonData.length = 0;
        document.getElementById('polygons').value = JSON.stringify(polygonData);
    });

    document.addEventListener('DOMContentLoaded', function() {
        const wilayahSelect = document.getElementById('wilayah_select');

        if (wilayahSelect) {
            wilayahSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const lat = selectedOption.getAttribute('data-lat');
                const lng = selectedOption.getAttribute('data-lng');

                // Remove any existing marker if a new option is selected
                if (currentWilayahMarker) {
                    map.removeLayer(currentWilayahMarker);
                    currentWilayahMarker = null;
                }

                if (lat && lng) {
                    // Center the map on the selected coordinates with a specific zoom level
                    map.setView([parseFloat(lat), parseFloat(lng)], 13); // Zoom level 13 is good for locality

                    // Add a new marker at the selected coordinates and open its popup
                    currentWilayahMarker = L.marker([parseFloat(lat), parseFloat(lng)]).addTo(map)
                        .bindPopup(selectedOption.value)
                        .openPopup();
                }
            });

            // Handle initial load if a "Nama Wilayah" is pre-selected (e.g., from old('wilayah'))
            const initialSelectedWilayah = wilayahSelect.querySelector('option[selected]');
            if (initialSelectedWilayah && initialSelectedWilayah.value !== "") {
                // Dispatch the change event to reuse the logic defined above
                wilayahSelect.dispatchEvent(new Event('change'));
            }
        }
    });
</script>
@endsection