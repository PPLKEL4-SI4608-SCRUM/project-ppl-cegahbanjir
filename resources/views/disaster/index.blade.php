@extends('layouts.app')

@section('head')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    #map,
    .modal-map {
        height: 300px;
        margin-top: 1rem;
        border-radius: 0.5rem;
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<!-- Main modal -->
<div class="max-w-5xl mx-auto p-6">
<h1 class="text-3xl font-bold mb-6 text-white">Laporan Kejadian Bencana</h1>
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-black-700">Tambah Laporan Baru</h2>
        <form method="POST" action="{{ route('laporan.store') }}" class="space-y-4" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="location" class="block text-black font-medium bg-[#121B22] px-3 py-1 rounded">Lokasi Kejadian</label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">
                <div id="map" class="w-full mt-4 rounded" style="height: 300px;"></div>
                @error('location')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="description" class="block text-black font-medium bg-[#121B22] px-3 py-1 rounded">Deskripsi Kejadian</label>
                <textarea id="description" name="description" rows="3" required
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block mb-2 text-black font-medium bg-[#121B22] px-3 py-1 rounded" for="file_input">Foto Lokasi Kejadian</label>
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    id="disaster_image" name="disaster_image" type="file" required>
                @error('disaster_image')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button type="submit" class="bg-[#FFA404] text-black px-4 py-2 rounded hover:bg-[#e69400] transition">
                    Simpan Laporan
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Riwayat Laporan</h2>
        @if ($reports->isEmpty())
            <p class="text-gray-600">Belum ada laporan yang tersedia.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Nama Pelapor</th>
                            <th class="px-4 py-2 border">Lokasi</th>
                            <th class="px-4 py-2 border">Deskripsi</th>
                            <th class="px-4 py-2 border">Foto</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $index => $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border">{{ $report->user->name ?? 'Tidak diketahui' }}</td>
                                <td class="px-4 py-2 border">{{ $report->location }}</td>
                                <td class="px-4 py-2 border">{{ $report->description }}</td>
                                <td class="px-4 py-2 border"><img class="card-img-top"
                                        src="{{ url('disaster_images/' . $report->disaster_image) }}" alt="image" /></td>
                                <td class="px-4 py-2 border">
                                    @if ($report->status == 'rejected')
                                        <span class="text-red-600 font-semibold">Rejected</span>
                                    @elseif($report->status == 'pending')
                                        <span class="text-yellow-600 font-semibold">Pending</span>
                                    @else
                                        <span class="text-blue-600 font-semibold">Approved</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">{{ $report->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-4 py-2 border">
                                    <button data-modal-target="default-modal{{ $report->id }}"
                                            data-modal-toggle="default-modal{{ $report->id }}"
                                            class="bg-blue-600 text-white rounded px-3 py-1">
                                        Detail
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div id="default-modal{{ $report->id }}" tabindex="-1" aria-hidden="true"
                                class="hidden fixed inset-0 z-50 overflow-y-auto overflow-x-hidden flex justify-center items-center">
                                <div class="relative w-full max-w-2xl p-4">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Laporan</h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="default-modal{{ $report->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="p-4 space-y-4">
                                            <form method="POST" action="{{ route('laporan.update', $report->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-4">
                                                    <label for="location{{ $report->id }}" class="block font-medium">Lokasi Kejadian</label>
                                                    <input type="text" id="location{{ $report->id }}" name="location" value="{{ $report->location }}" class="w-full border border-gray-300 rounded px-3 py-2">
                                                    <div id="map-edit-{{ $report->id }}" class="modal-map"></div>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="description" class="block font-medium">Deskripsi Kejadian</label>
                                                    <textarea id="description" name="description" class="w-full border border-gray-300 rounded px-3 py-2">{{ $report->description }}</textarea>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="disaster_image" class="block font-medium">Foto Lokasi</label>
                                                    <input type="file" id="disaster_image" name="disaster_image" class="w-full">
                                                </div>
                                                <div class="flex justify-end">
                                                    <button type="submit" class="bg-[#FFA404] text-black px-4 py-2 rounded hover:bg-[#e69400]">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    const modalId = "default-modal{{ $report->id }}";
                                    const mapId = "map-edit-{{ $report->id }}";
                                    const locInput = document.getElementById('location{{ $report->id }}');

                                    const mapTarget = document.getElementById(mapId);
                                    if (mapTarget && locInput) {
                                        setTimeout(() => {
                                            const map = L.map(mapId).setView([-6.2, 106.816666], 10);
                                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                attribution: '&copy; OpenStreetMap'
                                            }).addTo(map);

                                            let marker;
                                            const val = locInput.value;
                                            const regex = /(-?\d+\.\d+),\s*(-?\d+\.\d+)/;
                                            const match = val.match(regex);
                                            if (match) {
                                                const latlng = [parseFloat(match[1]), parseFloat(match[2])];
                                                marker = L.marker(latlng).addTo(map);
                                                map.setView(latlng, 13);
                                            }

                                            map.on('click', function (e) {
                                                const lat = e.latlng.lat.toFixed(6);
                                                const lon = e.latlng.lng.toFixed(6);
                                                if (marker) {
                                                    marker.setLatLng(e.latlng);
                                                } else {
                                                    marker = L.marker(e.latlng).addTo(map);
                                                }
                                                locInput.value = `${lat},${lon}`;

                                                // Reverse Geocoding
                                                fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        locInput.value = data.display_name || `${lat}, ${lon}`;
                                                    })
                                                    .catch(() => {
                                                        locInput.value = `${lat}, ${lon}`;
                                                    });
                                            });
                                        }, 500);
                                    }
                                });
                            </script>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var map = L.map('map').setView([-6.200000, 106.816666], 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker;

        map.on('click', function(e) {
            const lat = e.latlng.lat.toFixed(6);
            const lon = e.latlng.lng.toFixed(6);

            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }

            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`)
                .then(response => response.json())
                .then(data => {
                    const name = data.display_name || `${lat}, ${lon}`;
                    document.getElementById('location').value = name;
                })
                .catch(() => {
                    document.getElementById('location').value = `${lat}, ${lon}`;
                });
        });
    });
</script>
@endsection
