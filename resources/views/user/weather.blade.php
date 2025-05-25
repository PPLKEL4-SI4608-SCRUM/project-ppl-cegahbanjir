@extends('layouts.app')

@section('title', 'Dashboard Cuaca')

@section('content')
    @if($notifications)
        <div id="notification-alert"
             class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-yellow-200 text-yellow-800 px-6 py-4 rounded-lg shadow-lg z-50 max-w-md w-full">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold">📢 PERINGATAN BANJIR 📢</h3>
                <button onclick="document.getElementById('notification-alert').remove()"
                        class="text-xl font-bold text-yellow-800 hover:text-red-600">&times;</button>
            </div>
            <div class="space-y-2 max-h-60 overflow-y-auto">
                <div class="border-t border-yellow-400 pt-2">
                    <p><strong>Stasiun:</strong> {{ $stationName }}</p>
                    <p><strong>Lokasi:</strong> {{ $stationLocation }}</p>
                </div>
            </div>
            <a href="{{ $twitterShareUrl }}" target="_blank"
               class="inline-block px-6 py-3 mt-4 text-white bg-red-600 rounded-full text-center font-semibold hover:bg-red-500">
                Bagikan ke Twitter
            </a>
        </div>
    @endif

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <div class="max-w-5xl mx-auto px-4 py-8">

        {{-- 🔍 Search Bar --}}
        <div class="text-center mb-8">
            <h2 class="text-3xl font-semibold mb-4 text-white">Informasi Cuaca</h2>
            <form action="{{ route('user.weather.dashboard') }}" method="GET"
                  class="flex flex-wrap justify-center gap-3">
                <input type="text" name="search" placeholder="Cari nama kota..."
                       value="{{ request('search') }}"
                       class="px-5 py-3 rounded-full border border-gray-300 bg-white shadow w-64 text-sm">
                <button type="submit"
                        class="px-6 py-3 rounded-full bg-[#FFA404] text-white font-semibold hover:bg-[#e59300] text-sm">
                    <i class="fas fa-search mr-1"></i> Cari
                </button>
            </form>
        </div>

        {{-- 🌧️ Cuaca Saat Ini --}}
        <div class="bg-white/80 rounded-2xl p-6 shadow-xl space-y-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-6">
                <div class="flex items-center gap-6">
                    @if(request('search') && count($rainfalls) > 0)
                        @php
                            $kategori = str_replace('_', ' ', strtolower($rainfalls[0]->category ?? ''));
                            $iconClass = match($kategori) {
                                'rendah' => 'fa-solid fa-cloud',
                                'sedang' => 'fa-solid fa-cloud-rain',
                                'tinggi' => 'fa-solid fa-cloud-showers-heavy',
                                'sangat tinggi' => 'fa-solid fa-bolt',
                                default => 'fa-solid fa-question-circle'
                            };
                        @endphp

                        <div class="text-6xl text-blue-500">
                            <i class="{{ $iconClass }}" title="Kategori: {{ ucfirst($kategori) }}"></i>
                        </div>

                        <div>
                            <h3 class="text-4xl font-bold">{{ $rainfalls[0]->rainfall_amount }} mm</h3>
                            <p class="text-gray-600 text-sm">
                                {{ $rainfalls[0]->weatherStation->location ?? 'Lokasi tidak diketahui' }}
                            </p>
                            <p class="text-xs text-gray-500">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ \Carbon\Carbon::parse($rainfalls[0]->date)->format('d M Y') }}
                            </p>
                            <p class="text-sm">
                                <i class="fas fa-bolt mr-1"></i> Intensitas: {{ $rainfalls[0]->intensity }}
                            </p>
                            <p class="text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Kategori: {{ ucfirst(str_replace('_', ' ', strtolower($rainfalls[0]->category))) }}
                            </p>
                        </div>
                    @elseif(request('search'))
                        <div class="text-sm text-gray-600">Data tidak tersedia.</div>
                    @else
                        {{-- ❌ Tidak ada pencarian, tidak tampil icon --}}
                        <div class="flex items-center gap-3 text-gray-400 italic text-sm">
                            <i class="fas fa-cloud text-6xl opacity-10"></i>
                            <span>Silakan cari kota untuk menampilkan data cuaca.</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- 🔮 Prakiraan 5 Hari --}}
            @if(!empty($forecast7days))
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">
                        <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>Prakiraan Cuaca 5 Hari Kedepan
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($forecast7days as $day)
                            @php
                                $parsedDate = \Carbon\Carbon::createFromFormat('Y-m-d', $day['dt']);
                            @endphp
                            <div class="bg-white/90 rounded-xl p-4 shadow text-sm text-gray-800 space-y-1">
                                <p class="font-semibold">{{ $parsedDate->translatedFormat('l, d M Y') }}</p>
                                <p><i class="fas fa-cloud-sun mr-1"></i> Cuaca: {{ $day['weather'][0]['description'] }}</p>
                                <p><i class="fas fa-temperature-high mr-1"></i> Max: {{ round($day['temp']['max']) }}°C</p>
                                <p><i class="fas fa-temperature-low mr-1"></i> Min: {{ round($day['temp']['min']) }}°C</p>
                                <p><i class="fas fa-tint mr-1"></i> Curah Hujan: {{ round($day['rain'], 2) }} mm</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
