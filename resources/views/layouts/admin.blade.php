<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Admin CegahBanjir') }}</title>
    <title>@yield('title') - Admin CeBan</title>

    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preload" as="image" href="{{ asset('images/background-banjir2.png') }}">
    <style>
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #0F1A21;
            transition: background 0.3s ease-in-out;
            /* Flexbox for sticky footer */
            display: flex; /* NEW */
            flex-direction: column; /* NEW */
            min-height: 100vh; /* Ensure body takes full viewport height */
        }
        .dropdown-menu {
            min-width: 220px;
            left: 0;
            top: 100%;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-cover bg-center min-h-screen text-white font-poppins"
      style="background-image: url('{{ asset('images/background-banjir2.png') }}')">
    <nav class="bg-[#0F1A21]/80 shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="CeBan" class="w-10 h-10 rounded-full object-cover">
                <span class="text-2xl font-semibold tracking-wide text-white">CeBan <span class="text-[#FFA404]">Admin</span></span>
            </a>
            <div class="flex items-center space-x-10">
                <div class="hidden md:flex space-x-6 text-sm font-medium">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#FFA404] transition">Dashboard</a>
                    
                    <div class="relative dropdown">
                        <button class="hover:text-[#FFA404] transition focus:outline-none flex items-center gap-1">
                            <i class="fas fa-cloud-sun text-sm"></i>
                            Manajemen Data Cuaca
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute hidden dropdown-menu bg-[#0F1A21] text-white rounded-md mt-2 shadow-lg z-10 border border-gray-600">
                            <a href="{{ route('admin.weather.stations.index') }}" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-broadcast-tower text-sm"></i>
                                Stasiun Cuaca
                            </a>
                            <a href="{{ route('admin.weather.rainfall.index') }}" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-cloud-rain text-sm"></i>
                                Data Curah Hujan
                            </a>
                        </div>
                    </div>

                    <div class="relative dropdown">
                        <button class="hover:text-[#FFA404] transition focus:outline-none flex items-center gap-1">
                            <i class="fas fa-water text-sm"></i>
                            Manajemen Data Banjir
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute hidden dropdown-menu bg-[#0F1A21] text-white rounded-md mt-2 shadow-lg z-10 border border-gray-600">
                            <a href="{{ route('admin.weather.predictions.index') }}" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-chart-line text-sm"></i>
                                Prediksi Banjir
                            </a>
                            <a href="{{ route('admin.disaster-reports.index') }}" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle text-sm"></i>
                                Laporan Bencana
                            </a>
                            <a href="{{ route('admin.weather.disaster-statistics') }}" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-chart-bar text-sm"></i>
                                Statistik Laporan Banjir
                            </a>
                            <a href="{{ route('admin.weather.notification.create') }}" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-bell text-sm"></i>
                                Notifikasi
                            </a>
                            <a href="{{ route('admin.artikels.index') }}" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-newspaper text-sm"></i>
                                Artikel Rekomendasi
                            </a>
                        </div>
                    </div>

                    <div class="relative dropdown">
                        <button class="hover:text-[#FFA404] transition focus:outline-none flex items-center gap-1">
                            <i class="fas fa-users text-sm"></i>
                            Manajemen Data Pengguna
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute hidden dropdown-menu bg-[#0F1A21] text-white rounded-md mt-2 shadow-lg z-10 border border-gray-600">
                            <a href="{{ route('admin.pengguna.index') }}" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-user text-sm"></i>
                                Data Pengguna
                            </a>
                            <a href="{{ route('admin.flood_history.index') }}" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-history text-sm"></i>
                                Riwayat Banjir
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-2 text-sm font-medium hover:text-[#FFA404] focus:outline-none transition">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M5.121 17.804A8 8 0 0112 4a8 8 0 016.879 13.804M15 21H9a3 3 0 01-3-3v-1a6 6 0 0112 0v1a3 3 0 01-3 3z"/>
                                </svg>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="bg-[#0F1A21] rounded-md shadow-md py-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                                     class="font-poppins text-white hover:bg-[#FFA404] hover:text-white transition px-4 py-2 block"
                                                     onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </nav>
    
    <main class="py-10 px-6 flex-grow"> @if(session('success'))
            <div class="bg-green-500/80 text-white px-4 py-3 rounded mb-4 shadow-md">
                {{ session('success') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="bg-yellow-500/80 text-white px-4 py-3 rounded mb-4 shadow-md">
                {{ session('warning') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500/80 text-white px-4 py-3 rounded mb-4 shadow-md">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>
    
    <footer class="bg-[#0F1A21]/90 text-white py-6 mt-12">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-4">
            <div>
                <h5 class="text-xl font-semibold mb-2">CeBan (Cegah Banjir)</h5>
                <p>Sistem peringatan dini dan pencegahan banjir</p>
            </div>
            <div class="text-md md:text-right">
                <h5 class="text-xl font-semibold mb-2">Kontak</h5>
                <p>Email: info@ceban.id<br>Telepon: (021) 1234-5678</p>
            </div>
        </div>
        <hr class="my-4 border-gray-600">
        <p class="text-center text-sm">&copy; {{ date('Y') }} CeBan. Hak Cipta Dilindungi.</p>
    </footer>
    @stack('scripts')
</body>
</html>