@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="bg-white/80 p-8 rounded-2xl shadow-xl backdrop-blur-md">
            <h1 class="text-2xl font-bold mb-2">Selamat datang, Pengguna CeBan!</h1>
            <p class="mb-6 text-gray-700">Ini adalah Halaman dashboard untuk pengguna <strong>CeBan</strong> (Cegah Banjir).</p>

            <h2 class="text-lg font-semibold mb-4">Quick Links</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Card: Laporan Bencana -->
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-bold text-gray-800">Laporan Bencana</h3>
                    <p class="text-sm text-gray-600 mt-1">Input & pantau laporan kejadian banjir</p>
                    <a href="{{ route('laporan.index') }}" class="mt-4 inline-block bg-yellow-400 text-white font-semibold px-4 py-2 rounded hover:bg-yellow-500">Akses</a>
                </div>

                <!-- Card: Data Curah Hujan -->
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-bold text-gray-800">Data Curah Hujan</h3>
                    <p class="text-sm text-gray-600 mt-1">Input dan edit data curah hujan</p>
                    <a href="#" class="mt-4 inline-block bg-yellow-400 text-white font-semibold px-4 py-2 rounded hover:bg-yellow-500">Akses</a>
                </div>

                <!-- Card: Prediksi Banjir -->
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-bold text-gray-800">Prediksi Banjir</h3>
                    <p class="text-sm text-gray-600 mt-1">Kelola prediksi potensi banjir</p>
                    <a href="#" class="mt-4 inline-block bg-yellow-400 text-white font-semibold px-4 py-2 rounded hover:bg-yellow-500">Akses</a>
                </div>

                <!-- Card: Parameter Peringatan -->
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-bold text-gray-800">Parameter Peringatan</h3>
                    <p class="text-sm text-gray-600 mt-1">Atur parameter peringatan banjir</p>
                    <a href="#" class="mt-4 inline-block bg-yellow-400 text-white font-semibold px-4 py-2 rounded hover:bg-yellow-500">Akses</a>
                </div>
            </div>
        </div>
    </div>
@endsection
