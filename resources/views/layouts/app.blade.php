<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'CegahBanjir') }}</title>
    <title>Cegah Banjir - Dashboard</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <!-- Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Preload background image -->
    <link rel="preload" as="image" href="{{ asset('images/background-banjir2.png') }}">

    <!-- Custom font style -->
    <style>
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #0F1A21;
            transition: background 0.3s ease-in-out;
        }
    </style>
    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tambahan penting agar <head> dari child ter-load -->
    @yield('head')
</head>

<body class="bg-cover bg-center min-h-screen text-gray-900 font-poppins"
    style="background-image: url('{{ asset('images/background-banjir2.png') }}')">

    <!-- Navbar -->
    <nav class="bg-[#0F1A21]/70 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo + Title -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Cegah Banjir Logo" class="w-10 h-10 rounded-full object-cover">
                <span class="text-3xl font-semibold tracking-wide">
                    Cegah<span class="text-[#FFA404]"> Banjir</span>
                </span>
            </div>

            <!-- Navigation + Profile -->
            <div class="flex items-center space-x-10">
                <!-- Main Links -->
                <div class="hidden md:flex space-x-6 text-sm font-medium">
                    <a href="{{ route('dashboard') }}" class="hover:text-[#FFA404] transition">Home</a>
                    <a href="#" class="hover:text-[#FFA404] transition">About</a>
                    <a href="{{ route('user.map') }}" class="hover:text-[#FFA404] transition">Interactive Map</a>
                    <a href="#" class="hover:text-[#FFA404] transition">Publications</a>
                    <a href="{{ route('user.weather.dashboard') }}" class="hover:text-[#FFA404] transition">Weather</a>
                    <a href="#" class="hover:text-[#FFA404] transition">Past Floods</a>
                </div>

                <!-- Profile Dropdown -->
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
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="py-12 px-6">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    @yield('scripts')
</body>

</html>