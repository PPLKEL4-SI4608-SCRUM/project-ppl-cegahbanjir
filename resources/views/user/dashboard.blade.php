@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-8 rounded-2xl shadow-xl text-white mb-10 md:mb-12">
        <h1 class="text-3xl font-extrabold mb-2">Selamat datang, {{ Auth::user()->name }}!</h1>
        <p class="text-blue-200 text-lg">Ini adalah dashboard Anda untuk memantau informasi dan tips seputar banjir.</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-xl mb-10 md:mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Akses Cepat</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div class="bg-gray-50 p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border-l-4 border-[#FFA404]">
                <div class="flex items-center justify-center bg-[#FFE8B7] w-12 h-12 rounded-full mb-4 mx-auto">
                    <i class="fas fa-exclamation-triangle text-[#FFA404] text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">Laporan Bencana</h3>
                <p class="text-sm text-gray-600 text-center mb-4">Input & pantau laporan kejadian banjir Anda.</p>
                <a href="{{ route('laporan.index') }}" class="block w-full text-center bg-[#FFA404] text-white font-bold py-3 rounded-lg hover:bg-[#FF8C00] transition duration-300">
                    Akses Laporan
                </a>
            </div>

            <div class="bg-gray-50 p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border-l-4 border-blue-500">
                <div class="flex items-center justify-center bg-blue-100 w-12 h-12 rounded-full mb-4 mx-auto">
                    <i class="fas fa-cloud-sun-rain text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">Prakiraan Cuaca</h3>
                <p class="text-sm text-gray-600 text-center mb-4">Lihat prakiraan cuaca terkini di lokasi Anda.</p>
                <a href="{{ route('user.weather.dashboard') }}" class="block w-full text-center bg-blue-500 text-white font-bold py-3 rounded-lg hover:bg-blue-600 transition duration-300">
                    Lihat Cuaca
                </a>
            </div>

            <div class="bg-gray-50 p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border-l-4 border-green-500">
                <div class="flex items-center justify-center bg-green-100 w-12 h-12 rounded-full mb-4 mx-auto">
                    <i class="fas fa-map-marker-alt text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">Titik Pantau</h3>
                <p class="text-sm text-gray-600 text-center mb-4">Pantau status titik potensi banjir di peta.</p>
                <a href="{{ route('user.map') }}" class="block w-full text-center bg-green-500 text-white font-bold py-3 rounded-lg hover:bg-green-600 transition duration-300">
                    Akses Peta
                </a>
            </div>
        </div>
    </div>

    {{-- Rekomendasi Artikel Banjir Section --}}
    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-8 rounded-2xl shadow-xl mb-10 md:mb-12">
        <h2 class="text-3xl font-extrabold text-indigo-800 text-center mb-4">Rekomendasi Tindakan Saat Banjir</h2>
        <p class="text-indigo-600 text-lg text-center mb-8">Informasi dan tips penting untuk kesiapan Anda menghadapi banjir.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach ($rekomendasis as $item)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">
                    <div class="p-6 flex-grow">
                        <div class="flex justify-center mb-4">
                            <img src="{{ url('artikel_icons/' . $item->icon_path) }}"
                                alt="{{ $item->title }} icon" class="w-16 h-16 object-contain">
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 text-center mb-3">{{ $item->title }}</h3>
                        <p class="text-sm text-gray-700 text-center leading-relaxed">
                            {{ Str::limit(strip_tags($item->description), 100) }}
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 text-center border-t border-gray-100">
                        <a href="{{ route('rekomendasi.show', $item->id) }}"
                            class="text-base font-semibold text-blue-600 hover:text-blue-800 hover:underline transition duration-300">
                            Selengkapnya <i class="fas fa-arrow-right ml-1 text-sm"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination links --}}
        <div class="mt-8">
            {{ $rekomendasis->links() }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="space-y-8">
            <div class="bg-white p-6 rounded-2xl shadow-xl">
                <h2 class="text-2xl font-bold text-gray-800 mb-5 border-b pb-4 border-gray-200">Profil Saya</h2>
                <div class="flex items-center mb-5">
                    <div class="h-20 w-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-4xl font-bold mr-5 flex-shrink-0">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-900">{{ Auth::user()->name }}</h3>
                        <p class="text-gray-600 text-base">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="pt-4 mt-2">
                    <a href="{{ route('profile.edit') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300 font-semibold">
                        <i class="fas fa-user-edit mr-2"></i> Edit Profil
                    </a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl">
                <h2 class="text-2xl font-bold text-gray-800 mb-5 border-b pb-4 border-gray-200">Aktivitas Terbaru</h2>
                <div class="space-y-4">
                    <div class="flex items-start bg-blue-50 p-4 rounded-lg">
                        <div class="h-10 w-10 rounded-full bg-blue-200 flex items-center justify-center text-blue-600 flex-shrink-0 mr-4">
                            <i class="fas fa-clock text-lg"></i>
                        </div>
                        <div>
                            <p class="text-base font-semibold text-gray-800">Login terakhir</p>
                            <p class="text-sm text-gray-600">{{ Auth::user()->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-start bg-green-50 p-4 rounded-lg">
                        <div class="h-10 w-10 rounded-full bg-green-200 flex items-center justify-center text-green-600 flex-shrink-0 mr-4">
                            <i class="fas fa-clipboard-list text-lg"></i>
                        </div>
                        <div>
                            <p class="text-base font-semibold text-gray-800">Laporan banjir terakhir</p>
                            <p class="text-sm text-gray-600">Belum ada laporan</p> {{-- You can dynamically fetch this --}}
                        </div>
                    </div>
                </div>
            </div>

            <x-emergency-numbers />
        </div>

        <div class="space-y-8 lg:col-span-2"> {{-- This column now spans 2 for better layout --}}
            <div class="bg-white p-6 rounded-2xl shadow-xl">
                <h2 class="text-2xl font-bold text-gray-800 mb-5 border-b pb-4 border-gray-200">Informasi Cuaca Hari Ini</h2>

                @if ($rainfall)
                    @php
                        $kategori = str_replace('_', ' ', strtolower($rainfall->category));
                        $icon = match($kategori) {
                            'rendah' => 'fa-cloud',
                            'sedang' => 'fa-cloud-rain',
                            'tinggi' => 'fa-cloud-showers-heavy',
                            'sangat tinggi' => 'fa-bolt',
                            default => 'fa-question'
                        };
                    @endphp

                    <div class="flex flex-col md:flex-row items-center md:justify-between gap-6">
                        <div class="text-center md:text-left flex-shrink-0">
                            <div class="text-6xl text-blue-600 mb-3">
                                <i class="fas {{ $icon }}"></i>
                            </div>
                            <div class="text-4xl font-extrabold text-gray-900">{{ number_format($rainfall->rainfall_amount, 2) }} mm</div>
                            <div class="text-lg text-gray-700 mt-2">
                                {{ $rainfall->weatherStation->name ?? 'Lokasi tidak diketahui' }}
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ \Carbon\Carbon::parse($rainfall->date)->format('d M Y') }}
                            </p>
                        </div>

                        <div class="w-full md:w-auto border-t md:border-t-0 md:border-l border-gray-200 pt-6 md:pt-0 md:pl-8 space-y-3">
                            <div class="flex items-center text-lg text-gray-700">
                                <i class="fas fa-tint text-blue-500 mr-3"></i>
                                Curah Hujan: <span class="font-semibold ml-1">{{ number_format($rainfall->rainfall_amount, 2) }} mm</span>
                            </div>
                            <div class="flex items-center text-lg text-gray-700">
                                <i class="fas fa-exclamation-circle text-blue-500 mr-3"></i>
                                Kategori: <span class="font-semibold ml-1">{{ ucfirst($kategori) }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-600 italic text-center py-4">Data cuaca belum tersedia.</p>
                @endif

                <div class="mt-6 text-center">
                    <a href="{{ route('user.weather.dashboard') }}" class="inline-block bg-blue-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-chart-area mr-2"></i> Lihat Prakiraan Lengkap
                    </a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-8 border-yellow-500">
                <div class="flex items-center mb-5">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-3xl mr-4"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Peringatan Dini Banjir</h2>
                </div>
                @if(count($peringatanDini) > 0)
                    @foreach($peringatanDini as $peringatan)
                        <div class="bg-yellow-50 p-5 rounded-lg mb-4 border border-yellow-200">
                            <p class="text-gray-800 font-medium mb-2">Waspada hujan lebat disertai angin kencang di wilayah <span class="text-yellow-700 font-bold">{{ $peringatan['lokasi'] }}</span> dan sekitarnya dalam 24 jam ke depan.</p>
                            <div class="flex items-center">
                                <div class="h-3 w-3 rounded-full bg-yellow-500 mr-3"></div>
                                <span class="text-sm font-semibold text-yellow-700">
                                    Status: {{ $peringatan['peringatan'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-600 italic text-center py-4">Tidak ada peringatan dini saat ini.</p>
                @endif

                <div class="mt-6 text-center">
                    <a href="{{ $twitterShareUrl }}" target="_blank"
                        class="inline-block px-6 py-3 text-white bg-red-600 rounded-lg text-center font-bold hover:bg-red-700 transition duration-300">
                        <i class="fab fa-twitter mr-2"></i> Bagikan Info Peringatan ke Twitter
                    </a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl">
                <h2 class="text-2xl font-bold text-gray-800 mb-5 border-b pb-4 border-gray-200">Titik Pantau Banjir</h2>
                <div class="space-y-4">
                    @forelse ($maps as $map)
                        @php
                            $polygonData = is_array($map->polygons) ? $map->polygons : json_decode($map->polygons, true);
                            $risikos = collect($polygonData)
                                ->pluck('tingkat_risiko')
                                ->filter()
                                ->unique()
                                ->toArray();

                            $badgeHtml = '';
                            foreach ($risikos as $tingkat) {
                                $badgeHtml .= match(strtolower($tingkat)) {
                                    'sangat tinggi' => "<span class='px-3 py-1 bg-red-600 text-white rounded-full text-xs font-semibold'>Sangat Tinggi</span>",
                                    'tinggi' => "<span class='px-3 py-1 bg-orange-500 text-white rounded-full text-xs font-semibold'>Tinggi</span>",
                                    'sedang' => "<span class='px-3 py-1 bg-yellow-400 text-gray-900 rounded-full text-xs font-semibold'>Sedang</span>",
                                    'rendah' => "<span class='px-3 py-1 bg-green-400 text-gray-900 rounded-full text-xs font-semibold'>Rendah</span>",
                                    default => "<span class='px-3 py-1 bg-gray-300 text-gray-800 rounded-full text-xs font-semibold'>Tidak diketahui</span>",
                                };
                            }
                        @endphp
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <span class="font-semibold text-lg text-gray-800 mb-2 sm:mb-0">{{ $map->wilayah }}</span>
                            <span class="flex gap-2 flex-wrap justify-end">{!! $badgeHtml !!}</span>
                        </div>
                    @empty
                        <p class="text-gray-600 italic text-center py-4">Belum ada titik pantau banjir yang tersedia.</p>
                    @endforelse
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('user.map') }}" class="inline-block bg-purple-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-purple-700 transition duration-300">
                        <i class="fas fa-map-marked-alt mr-2"></i> Lihat Semua Titik Pantau
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection