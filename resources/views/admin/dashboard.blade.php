@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 mt-10">
    <div class="bg-white bg-opacity-90 backdrop-blur-md rounded-2xl shadow-lg p-6 text-gray-800">
        <h2 class="text-2xl font-semibold mb-4">Selamat datang, {{ Auth::user()->name }}!</h2>
        <p class="mb-6">Ini adalah panel admin <strong>CeBan (Cegah Banjir)</strong>.</p>

        <h3 class="text-lg font-medium mb-4">Quick Links</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div class="bg-[#F8F9FA] rounded-xl shadow p-4 text-center hover:shadow-md transition">
                <h4 class="font-semibold text-lg mb-1">Stasiun Cuaca</h4>
                <p class="text-sm text-gray-600 mb-3">Kelola stasiun cuaca</p>
                <a href="{{ route('admin.weather.stations.index') }}" class="bg-[#FFA404] hover:bg-[#0F1A21] text-white font-semibold py-2 px-4 rounded">Akses</a>
            </div>

            <!-- Card 2 -->
            <div class="bg-[#F8F9FA] rounded-xl shadow p-4 text-center hover:shadow-md transition">
                <h4 class="font-semibold text-lg mb-1">Data Curah Hujan</h4>
                <p class="text-sm text-gray-600 mb-3">Input dan edit data curah hujan</p>
                <a href="{{ route('admin.weather.rainfall.index') }}" class="bg-[#FFA404] hover:bg-[#0F1A21] text-white font-semibold py-2 px-4 rounded">Akses</a>
            </div>

            <!-- Card 3 -->
            <div class="bg-[#F8F9FA] rounded-xl shadow p-4 text-center hover:shadow-md transition">
                <h4 class="font-semibold text-lg mb-1">Prediksi Banjir</h4>
                <p class="text-sm text-gray-600 mb-3">Kelola prediksi potensi banjir</p>
                <a href="{{ route('admin.weather.predictions.index') }}" class="bg-[#FFA404] hover:bg-[#0F1A21] text-white font-semibold py-2 px-4 rounded">Akses</a>
            </div>

            <!-- Card 4 -->
            <div class="bg-[#F8F9FA] rounded-xl shadow p-4 text-center hover:shadow-md transition">
                <h4 class="font-semibold text-lg mb-1">Parameter Peringatan</h4>
                <p class="text-sm text-gray-600 mb-3">Atur parameter peringatan banjir</p>
                <a href="{{ route('admin.weather.parameters.index') }}" class="bg-[#FFA404] hover:bg-[#0F1A21] text-white font-semibold py-2 px-4 rounded">Akses</a>
            </div>
        </div>
    </div>
</div>
@endsection
