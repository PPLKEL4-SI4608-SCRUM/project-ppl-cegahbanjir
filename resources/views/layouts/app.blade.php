<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CONSOLIDATED TITLE TAG: Gabungkan menjadi satu --}}
    <title>@yield('title', config('app.name', 'CegahBanjir'))</title>

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
                <div class="hidden md:flex space-x-6 text-sm font-medium text-white">
                    {{-- Home Link --}}
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-1 hover:text-[#FFA404] transition group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 group-hover:text-[#FFA404] transition">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125h9.75a1.125 1.125 0 0 0 1.125-1.125V9.75m-6 9.375V11.25a3.75 3 0 0 1 7.5 0v8.875m-12 .75h10.125c.621 0 1.125-.504 1.125-1.125v-9.75C20.25 6.477 17.773 4 14.75 4s-5.5 2.477-5.5 5.5v2.25" />
                        </svg>
                        <span>Home</span>
                    </a>

                    {{-- About Link --}}
                    <a href="{{ route('about') }}" class="flex items-center space-x-1 hover:text-[#FFA404] transition group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 group-hover:text-[#FFA404] transition">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 .655.247 1.5 1.5 0 0 0 .918.599 1.5 1.5 0 0 0 1.403-.655.75.75 0 0 1 .247-.655L15.75 9.75m-4.5 1.5H5.25m4.5 0H9m1.5-6.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>About</span>
                    </a>

                    {{-- Weather Dropdown --}}
                    <button id="weatherDropdownButton" data-dropdown-toggle="weatherDropdown" class="flex items-center space-x-1 hover:text-[#FFA404] transition group" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 group-hover:text-[#FFA404] transition">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.364-.386 1.591-1.591M3 12H5.25m-.386-6.364 1.591 1.591M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span>Weather</span>
                        {{-- Dropdown arrow icon --}}
                        <svg class="w-2.5 h-2.5 ms-2.5 group-hover:text-[#FFA404] transition" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    {{-- Dropdown menu for Weather --}}
                    <div id="weatherDropdown" class="z-10 hidden rounded-lg shadow w-44 bg-white dark:bg-[#121B22]">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="weatherDropdownButton">
                            <li>
                                <a href="{{ route('user.weather.dashboard') }}" class="flex items-center px-4 py-2 hover:bg-[#FFA404] hover:text-black dark:hover:bg-[#FFA404] dark:hover:text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.364-.386 1.591-1.591M3 12H5.25m-.386-6.364 1.591 1.591M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <span>Current Weather</span>
                                </a>
                            </li>
                            {{-- Tambahkan link lain terkait cuaca jika ada, contoh: --}}
                            {{-- <li>
                                <a href="{{ route('user.weather.forecast') }}" class="flex items-center px-4 py-2 hover:bg-[#FFA404] hover:text-black dark:hover:bg-[#FFA404] dark:hover:text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3M10 9a2 2 0 1 1 0 4 2 2 0 0 1 0-4Zm0 0L7 6m3 3L13 6m0 0h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2Z" />
                                    </svg>
                                    <span>Weather Forecast</span>
                                </a>
                            </li> --}}
                        </ul>
                    </div>

                    {{-- Flood Data Dropdown --}}
                    <button id="floodDataDropdownButton" data-dropdown-toggle="floodDataDropdown" class="flex items-center space-x-1 hover:text-[#FFA404] transition group" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 group-hover:text-[#FFA404] transition">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 11.25 3-3m0 0 3 3m-3-3v8.25M12 21A9 9 0 1 0 3 12a9 9 0 0 0 18 0Z" />
                        </svg>
                        <span>Flood Data</span>
                        {{-- Dropdown arrow icon --}}
                        <svg class="w-2.5 h-2.5 ms-2.5 group-hover:text-[#FFA404] transition" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    {{-- Dropdown menu for Flood Data --}}
                    <div id="floodDataDropdown" class="z-10 hidden rounded-lg shadow w-44 bg-white dark:bg-[#121B22]">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="floodDataDropdownButton">
                            <li>
                                <a href="{{ route('user.map') }}" class="flex items-center px-4 py-2 hover:bg-[#FFA404] hover:text-black dark:hover:bg-[#FFA404] dark:hover:text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.5 1.125.04.045m-.674-.252-.04-.045M12 2.25h.004M12 2.25L10.5 4.72M9 10.5V15m0 0H7.5M10.5 6h9V4.5H10.5M9 10.5H7.5M10.5 6.75L12 2.25M15 10.5V15M15 15h2.25V4.5H15Z" />
                                    </svg>
                                    <span>Interactive Map</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.flood_history.index') }}" class="flex items-center px-4 py-2 hover:bg-[#FFA404] hover:text-black dark:hover:bg-[#FFA404] dark:hover:text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 11.25 3-3m0 0 3 3m-3-3v8.25M12 21A9 9 0 1 0 3 12a9 9 0 0 0 18 0Z" />
                                    </svg>
                                    <span>Past Floods</span>
                                </a>
                            </li>
                        </ul>
                    </div>
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
                                    class="font-poppins text-white
                                        hover:bg-[#FFA404]/90     
                                        hover:text-white
                                        focus:bg-[#FFA404]/90
                                        focus:text-white          
                                        transition px-4 py-2 block">
                                    {{ __('Edit Profile') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                        class="font-poppins text-white
                                            hover:bg-[#FFA404]/90
                                            hover:text-white
                                            focus:bg-[#FFA404]/90
                                            focus:text-white
                                            transition px-4 py-2 block"
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