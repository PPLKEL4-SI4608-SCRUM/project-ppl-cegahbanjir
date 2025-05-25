@extends('layouts.admin')
@section('content')
<div class="max-w-7xl mx-auto px-6 mt-10">
    <div class="bg-white bg-opacity-80 backdrop-blur-md rounded-2xl shadow-lg p-6 text-gray-800">
        <h2 class="text-2xl font-semibold mb-4">Selamat datang, {{ Auth::user()->name }}!</h2>
        <p class="mb-8">Ini adalah panel admin <strong>CeBan (Cegah Banjir)</strong>.</p>
        
        <!-- 1. Manajemen Data Cuaca -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-blue-500 p-2 rounded-lg">
                    <i class="fas fa-cloud-sun text-white text-lg"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">Manajemen Data Cuaca</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Card - Stasiun Cuaca -->
                <div class="bg-[#F8F9FA] rounded-xl shadow p-4 text-center hover:shadow-md transition border-l-4 border-blue-500">
                    <div class="flex justify-center mb-3">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-broadcast-tower text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <h4 class="font-semibold text-lg mb-1">Stasiun Cuaca</h4>
                    <p class="text-sm text-gray-600 mb-3">Kelola stasiun cuaca</p>
                    <a href="{{ route('admin.weather.stations.index') }}" class="bg-[#FFA404] hover:bg-[#0F1A21] text-white font-semibold py-2 px-4 rounded flex items-center justify-center transition">
                        <i class="fas fa-broadcast-tower mr-2"></i> Akses
                    </a>
                </div>
                <!-- Card - Data Curah Hujan -->
                <div class="bg-[#F8F9FA] rounded-xl shadow p-4 text-center hover:shadow-md transition border-l-4 border-blue-500">
                    <div class="flex justify-center mb-3">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-cloud-rain text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <h4 class="font-semibold text-lg mb-1">Data Curah Hujan</h4>
                    <p class="text-sm text-gray-600 mb-3">Input dan edit data curah hujan</p>
                    <a href="{{ route('admin.weather.rainfall.index') }}" class="bg-[#FFA404] hover:bg-[#0F1A21] text-white font-semibold py-2 px-4 rounded flex items-center justify-center transition">
                        <i class="fas fa-cloud-rain mr-2"></i> Akses
                    </a>
                </div>
            </div>
        </div>

        <!-- 2. Manajemen Data Banjir -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-cyan-500 p-2 rounded-lg">
                    <i class="fas fa-water text-white text-lg"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">Manajemen Data Banjir</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <!-- Card - Prediksi Banjir -->
                <div class="bg-[#F8F9FA] rounded-xl shadow p-4 text-center hover:shadow-md transition border-l-4 border-cyan-500">
                    <div class="flex justify-center mb-3">
                        <div class="bg-cyan-100 p-3 rounded-full">
                            <i class="fas fa-chart-line text-cyan-600 text-xl"></i>
                        </div>
                    </div>
                    <h4 class="font-semibold text-lg mb-1">Prediksi Banjir</h4>
                    <p class="text-sm text-gray-600 mb-3">Kelola prediksi potensi banjir</p>
                    <a href="{{ route('admin.flood-maps.index') }}" class="bg-[#FFA404] hover:bg-[#0F1A21] text-white font-semibold py-2 px-4 rounded flex items-center justify-center transition">
                        <i class="fas fa-chart-line mr-2"></i> Akses
                    </a>
                </div>
                <!-- Card - Laporan Bencana -->
                <div class="bg-[#F8F9FA] rounded-xl shadow p-4 text-center hover:shadow-md transition border-l-4 border-cyan-500">
                    <div class="flex justify-center mb-3">
                        <div class="bg-cyan-100 p-3 rounded-full">
                            <i class="fas fa-exclamation-triangle text-cyan-600 text-xl"></i>
                        </div>
                    </div>
                    <h4 class="font-semibold text-lg mb-1">Laporan Bencana</h4>
                    <p class="text-sm text-gray-600 mb-3">Terima atau tolak laporan dari user</p>
                    <a href="{{ route('admin.disaster-reports.index') }}" class="bg-[#FFA404] hover:bg-[#0F1A21] text-white font-semibold py-2 px-4 rounded flex items-center justify-center transition">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Akses
                    </a>
                </div>
                <!-- Card - Statistik Laporan Banjir -->
                <div class="bg-[#F8F9FA] rounded-xl shadow p-4 text-center hover:shadow-md transition border-l-4 border-cyan-500">
                    <div class="flex justify-center mb-3">
                        <div class="bg-cyan-100 p-3 rounded-full">
                            <i class="fas fa-chart-bar text-cyan-600 text-xl"></i>
                        </div>
                    </div>
                    <h4 class="font-semibold text-lg mb-1">Statistik Laporan Banjir</h4>
                    <p class="text-sm text-gray-600 mb-3">Lihat statistik dan data laporan bencana</p>
                    <a href="{{ route('admin.weather.disaster-statistics') }}" class="bg-[#FFA404] hover:bg-[#0F1A21] text-white font-semibold py-2 px-4 rounded flex items-center justify-center transition">
                        <i class="fas fa-chart-bar mr-2"></i> Akses
                    </a>
                </div>
                <!-- Card - Notifikasi -->
                <div class="bg-[#F8F9FA] rounded-xl shadow p-4 text-center hover:shadow-md transition border-l-4 border-cyan-500">
                    <div class="flex justify-center mb-3">
                        <div class="bg-cyan-100 p-3 rounded-full">
                            <i class="fas fa-bell text-cyan-600 text-xl"></i>
                        </div>
                    </div>
                    <h4 class="font-semibold text-lg mb-1">Notifikasi</h4>
                    <p class="text-sm text-gray-600 mb-3">Berikan notifikasi banjir kepada pengguna</p>
                    <a href="{{ route('admin.weather.notification.create') }}" class="bg-[#FFA404] hover:bg-[#0F1A21] text-white font-semibold py-2 px-4 rounded flex items-center justify-center transition">
                        <i class="fas fa-bell mr-2"></i> Akses
                    </a>
                </div>
                <!-- Card - Artikel Rekomendasi -->
                <div class="bg-[#F8F9FA] rounded-xl shadow p-4 text-center hover:shadow-md transition border-l-4 border-cyan-500">
                    <div class="flex justify-center mb-3">
                        <div class="bg-cyan-100 p-3 rounded-full">
                            <i class="fas fa-newspaper text-cyan-600 text-xl"></i>
                        </div>
                    </div>
                    <h4 class="font-semibold text-lg mb-1">Artikel Rekomendasi</h4>
                    <p class="text-sm text-gray-600 mb-3">Kelola artikel dan solusi banjir</p>
                    <a href="{{ route('admin.artikels.index') }}" class="bg-[#FFA404] hover:bg-[#0F1A21] text-white font-semibold py-2 px-4 rounded flex items-center justify-center transition">
                        <i class="fas fa-newspaper mr-2"></i> Akses
                    </a>
                </div>
            </div>
        </div>
                <!-- Card - Peta Interaktif -->
                    <div class="bg-[#F8F9FA] rounded-xl shadow p-4 text-center hover:shadow-md transition border-l-4 border-cyan-500">
                            <div class="flex justify-center mb-3">
                                <div class="bg-cyan-100 p-3 rounded-full">
                                    <i class="fas fa-map text-cyan-600 text-xl"></i>
                                </div>
                            </div>
                            <h4 class="font-semibold text-lg mb-1">Peta Interaktif</h4>
                            <p class="text-sm text-gray-600 mb-3">Membuat mapping Peta Interaktif</p>
                            <a href="{{ route('admin.flood-maps.index') }}" class="bg-[#FFA404] hover:bg-[#0F1A21] text-white font-semibold py-2 px-4 rounded flex items-center justify-center transition">
                                <i class="fas fa-map mr-2"></i> Akses
                            </a>
                        </div>  
        <!-- 3. Manajemen Data Pengguna -->
        <div class="mb-6 mt-10">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-green-500 p-2 rounded-lg">
                    <i class="fas fa-users text-white text-lg"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">Manajemen Data Pengguna</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Card - Data Pengguna -->
                <div class="bg-[#F8F9FA] rounded-xl shadow p-4 text-center hover:shadow-md transition border-l-4 border-green-500">
                    <div class="flex justify-center mb-3">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-user text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <h4 class="font-semibold text-lg mb-1">Data Pengguna</h4>
                    <p class="text-sm text-gray-600 mb-3">Kelola data pengguna aplikasi</p>
                    <a href="{{ route('admin.pengguna.index') }}" class="bg-[#FFA404] hover:bg-[#0F1A21] text-white font-semibold py-2 px-4 rounded flex items-center justify-center transition">
                        <i class="fas fa-user mr-2"></i> Akses
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection