<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CONSOLIDATED TITLE TAG: Gabungkan menjadi satu --}}
    <title>@yield('title', config('app.name', 'CegahBanjir')) - Cegah Banjir</title>

    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preload" as="image" href="{{ asset('images/background-banjir2.png') }}">

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIINfBKMOBM7gmkAEQCDv6Eq0tUIAKabKLQ="
        crossorigin=""/>

    {{-- Leaflet Control Geocoder CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <style>
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        /* Perbaikan untuk Sticky Footer */
        body {
            background-color: #0F1A21;
            transition: background 0.3s ease-in-out;
            display: flex; /* Mengaktifkan Flexbox */
            flex-direction: column; /* Mengatur arah vertikal */
            min-height: 100vh; /* Memastikan body setidaknya setinggi viewport */
        }

        /* Essential Leaflet map container styling (if used on a page) */
        #map {
            height: 300px; /* Default height, can be overridden per page */
            width: 100%;
            border-radius: 0.5rem;
            overflow: hidden;
            margin-top: 1rem;
        }
    </style>
    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('head') {{-- Ini sudah benar untuk @section('head') dari child view --}}
    @stack('styles') {{-- Tambahkan ini jika Anda ingin @push('styles') dari child view --}}
</head>

<body class="bg-cover bg-center text-gray-900 font-poppins"
    style="background-image: url('{{ asset('images/background-banjir2.png') }}')">

    <nav class="bg-[#0F1A21]/70 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2"> {{-- Ubah agar logo juga link ke dashboard --}}
                <img src="{{ asset('images/logo.png') }}" alt="Cegah Banjir Logo" class="w-10 h-10 rounded-full object-cover">
                <span class="text-3xl font-semibold tracking-wide">
                    Cegah<span class="text-[#FFA404]"> Banjir</span>
                </span>
            </a>

            <div class="flex items-center space-x-10">
                <div class="hidden md:flex space-x-6 text-sm font-medium">
                    <a href="{{ route('dashboard') }}" class="hover:text-[#FFA404] transition">Home</a>
                    <a href="{{ route('about') }}" class="hover:text-[#FFA404] transition">About</a>
                    <a href="{{ route('user.map') }}" class="hover:text-[#FFA404] transition">Interactive Map</a>
                    <a href="{{ route('user.weather.dashboard') }}" class="hover:text-[#FFA404] transition">Weather</a>
                    <a href="{{ route('user.flood_history.index') }}" class="hover:text-[#FFA404] transition">Past Floods</a>
                </div>

                <div class="relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-2 text-sm font-medium hover:text-[#FFA404] focus:outline-none transition">
                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A8 8 0 0112 4a8 8 0 016.879 13.804M15 21H9a3 3 0 01-3-3v-1a6 6 0 0112 0v1a3 3 0 01-3 3z" />
                                </svg>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-[#0F1A21] rounded-md shadow-md py-2">
                                <x-dropdown-link href="{{ route('profile.edit') }}"
                                    class="font-poppins text-white hover:bg-[#FFA404]/30 hover:text-white transition px-4 py-2 block">
                                    {{ __('Edit Profile') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                        class="font-poppins text-white hover:bg-[#FFA404]/30 hover:text-white transition px-4 py-2 block"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
                {{-- Hamburger menu for mobile --}}
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        {{-- Mobile menu (hidden by default) --}}
        <div id="mobile-menu" class="hidden md:hidden bg-[#0F1A21]/90 px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-[#FFA404] hover:text-white transition">Home</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-[#FFA404] hover:text-white transition">About</a>
            <a href="{{ route('user.map') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-[#FFA404] hover:text-white transition">Interactive Map</a>
            <a href="{{ route('user.weather.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-[#FFA404] hover:text-white transition">Weather</a>
            <a href="{{ route('user.flood_history.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-[#FFA404] hover:text-white transition">Past Floods</a>
        </div>
    </nav>

    <main class="flex-grow py-12 px-6"> {{-- flex-grow agar main mengambil sisa ruang --}}
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

    {{-- Leaflet JavaScript --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20n6fxyVa+Rp3whzFDlQaQoPdo+zRdJ35hQ8Yc+oLlA="
        crossorigin=""></script>

    {{-- Leaflet Control Geocoder JavaScript (MUST be after Leaflet JS) --}}
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    {{-- Flowbite JS (Gunakan versi yang disarankan atau yang sudah Anda pakai di admin blade) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    {{-- Tambahkan script untuk mobile menu --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>

    @stack('scripts') {{-- Untuk script yang di-push dari child views --}}
    @yield('scripts') {{-- Tetap dipertahankan sebagai fallback atau untuk section 'scripts' --}}
</body>
</html>