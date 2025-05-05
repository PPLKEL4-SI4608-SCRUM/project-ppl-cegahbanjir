@extends('layouts.app')

@section('title', 'Peta Titik Banjir')

@section('content')
<div class="py-12 px-4 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-4xl bg-[#0F1A21]/90 p-8 rounded-lg shadow-lg relative">

        <h1 class="text-3xl font-bold text-white text-center mb-6">Peta Titik Banjir</h1>
        <link href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css" rel="stylesheet">

        <!-- Search Bar -->
        <div class="text-center mb-6">
            <form method="GET" action="{{ route('user.map') }}" class="flex justify-center gap-2 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kota..."
                    class="px-6 py-2 w-64 rounded-full border-none bg-gray-800 text-white placeholder-gray-400 focus:outline-none">
                <button type="submit"
                    class="px-6 py-2 bg-[#FFA404] text-white rounded-full hover:bg-[#ff8c00] flex items-center gap-2">
                    <i class="fa-regular fa-search"></i> Cari
                </button>
            </form>
        </div>

        @php
            $first = $maps->first();
            $hasImage = $first && $first->gambar;
            $hasSearch = request()->filled('search');
        @endphp

        <!-- Slider Wrapper -->
        <div class="relative w-full h-[400px] rounded overflow-hidden shadow-lg">
            <!-- MAP -->
            <div id="map-slide" class="slide z-0">
                <div id="map" style="height: 400px;"></div>
            </div>

            <!-- GAMBAR -->
            @if($hasSearch && $hasImage)
            <div id="image-slide" class="slide hidden flex items-center justify-center z-0" style="background-color: transparent;">
                <img src="{{ asset('storage/' . $first->gambar) }}" class="max-h-[380px] rounded shadow-lg object-contain" alt="Gambar Wilayah">
            </div>
            @endif

            <!-- TOMBOL -->
            @if($hasSearch && $hasImage)
            <button onclick="showMap()"
                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white text-gray-800 hover:bg-gray-200 hover:text-[#FFA404]
                       w-10 h-10 rounded-full shadow-lg flex items-center justify-center transition duration-300 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button onclick="showImage()"
                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white text-gray-800 hover:bg-gray-200 hover:text-[#FFA404]
                       w-10 h-10 rounded-full shadow-lg flex items-center justify-center transition duration-300 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            @endif
        </div>
    </div>
</div>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    const map = L.map('map').setView([-6.9147, 107.6098], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    @foreach ($maps as $map)
        L.marker([{{ $map->latitude }}, {{ $map->longitude }}])
            .addTo(map)
            .bindPopup('<strong>{{ $map->wilayah }}</strong><br>Lat: {{ $map->latitude }}<br>Lng: {{ $map->longitude }}');
    @endforeach

    function showMap() {
        document.getElementById('map-slide').classList.remove('hidden');
        const imgSlide = document.getElementById('image-slide');
        if (imgSlide) imgSlide.classList.add('hidden');
        setTimeout(() => map.invalidateSize(), 100);
    }

    function showImage() {
        document.getElementById('map-slide').classList.add('hidden');
        const imgSlide = document.getElementById('image-slide');
        if (imgSlide) imgSlide.classList.remove('hidden');
    }
</script>

<style>
    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: transparent;
    }
</style>
@endsection
