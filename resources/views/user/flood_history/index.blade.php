@extends('layouts.app')

@section('title', 'Riwayat Banjir - CeBan')

@section('head')
    {{-- Add any specific CSS for this page if needed, e.g., if you have custom input styles not in app.css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEbFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Custom styles for search input focus if not handled globally by Tailwind config */
        .search-input:focus {
            border-color: #FFA404; /* your brand orange */
            box-shadow: 0 0 0 3px rgba(255, 164, 4, 0.5); /* Semi-transparent orange ring */
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-6 mt-10">
        <div class="bg-white bg-opacity-80 backdrop-blur-md rounded-2xl shadow-lg p-6 text-gray-800 font-poppins">

            {{-- Page Header --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 border-b-2 border-gray-200 pb-4">
                <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <i class="fas fa-history text-[#FFA404]"></i> Riwayat Kejadian Banjir
                </h2>
                {{-- Search Bar --}}
                <form action="{{ route('user.flood_history.index') }}" method="GET" class="w-full sm:w-auto mt-4 sm:mt-0">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Cari berdasarkan lokasi..."
                               value="{{ $search ?? '' }}"
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none search-input text-gray-800 placeholder-gray-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        @if ($search)
                            <a href="{{ route('user.flood_history.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times-circle"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4 shadow">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4 shadow">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Flood History Cards --}}
            @forelse ($floods as $flood)
                <div class="bg-white shadow-md rounded-xl overflow-hidden mb-5 p-5 flex flex-col md:flex-row items-stretch gap-5 border-l-4 border-[#FFA404] hover:shadow-lg transition transform hover:-translate-y-1">
                    {{-- Gambar --}}
                    <div class="flex-shrink-0 w-full md:w-56 h-36 rounded-lg overflow-hidden shadow-inner">
                        @if ($flood->images && Storage::disk('public')->exists($flood->images))
                            <img src="{{ asset('storage/' . $flood->images) }}" alt="Gambar Banjir di {{ $flood->location }}"
                                class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/placeholder-flood.jpg') }}" alt="Tidak ada gambar"
                                class="w-full h-full object-cover bg-gray-200 flex items-center justify-center text-gray-500">
                        @endif
                    </div>

                    {{-- Konten --}}
                    <div class="flex-1 flex flex-col justify-between">
                        {{-- Lokasi dan Tanggal --}}
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-2">
                            <h3 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-blue-500"></i> {{-- Map marker icon for location --}}
                                {{ $flood->location }}
                            </h3>
                            <span class="text-sm text-gray-500 font-medium flex items-center gap-1">
                                <i class="fas fa-calendar-alt text-purple-500"></i> {{-- Calendar icon for date --}}
                                {{ \Carbon\Carbon::parse($flood->date)->format('d F Y') }}
                            </span>
                        </div>

                        {{-- Deskripsi --}}
                        <p class="text-base text-gray-700 leading-relaxed mb-3">
                            <i class="fas fa-info-circle text-green-500 mr-2"></i> {{-- Info icon for description --}}
                            {{ Str::limit($flood->impact, 200) }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="bg-white shadow-md rounded-xl p-5 text-center text-gray-600">
                    Tidak ada riwayat banjir yang ditemukan.
                </div>
            @endforelse

            <div class="mt-6 flex justify-center">
                {{ $floods->links() }}
            </div>
        </div>
    </div>
@endsection