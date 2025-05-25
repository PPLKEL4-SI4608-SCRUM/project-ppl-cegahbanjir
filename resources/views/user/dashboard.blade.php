@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Selamat datang, {{ Auth::user()->name }}!</h1>
        <p class="text-white/80 mt-2">Ini adalah dashboard untuk pengguna <strong>CeBan</strong> (Cegah Banjir)</p>
    </div>
    
    <!-- Quick Links Section -->
    <div class="bg-white/80 p-6 rounded-2xl shadow-xl backdrop-blur-md mb-8">
        <h2 class="text-xl font-semibold text-[#0F1A21] mb-4">Quick Links</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Card: Laporan Bencana -->
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold text-gray-800">Laporan Bencana</h3>
                <p class="text-sm text-gray-600 mt-1">Input & pantau laporan kejadian banjir</p>
                <a href="{{ route('laporan.index') }}" class="mt-4 inline-block bg-[#FFA404] text-white font-semibold px-4 py-2 rounded-lg hover:bg-[#FF8C00] transition">Akses</a>
            </div>
            
            <!-- Card: Prakiraan Cuaca -->
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold text-gray-800">Prakiraan Cuaca</h3>
                <p class="text-sm text-gray-600 mt-1">Lihat prakiraan cuaca terkini</p>
                <a href="{{ route('user.weather.dashboard') }}" class="mt-4 inline-block bg-[#FFA404] text-white font-semibold px-4 py-2 rounded-lg hover:bg-[#FF8C00] transition">Akses</a>
            </div>
            
            <!-- Card: Titik Pantau -->
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold text-gray-800">Titik Pantau</h3>
                <p class="text-sm text-gray-600 mt-1">Pantau status titik banjir</p>
                <a href="{{ route('user.map') }}" class="mt-4 inline-block bg-[#FFA404] text-white font-semibold px-4 py-2 rounded-lg hover:bg-[#FF8C00] transition">Akses</a>
            </div>
        </div>
    </div>

    {{-- ✨ Rekomendasi Artikel Banjir --}}
            <<div class="bg-white/80 p-6 rounded-2xl shadow-xl backdrop-blur-md mb-8">
                <h2 class="text-2xl font-extrabold text-blue-700 text-center">Rekomendasi Tindakan Saat Banjir</h2>
                <p class="text-gray-500 text-center mb-6">Jadi apa yang harus kamu lakukan ketika banjir ada di daerah kamu?</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($rekomendasis as $item)
                        <div class="bg-white border border-gray-300 rounded-xl text-center shadow-sm hover:shadow-md w-full max-w-xs py-6 px-4 flex flex-col justify-between">
                            <div class="flex justify-center mb-4">
                                <img src="{{ url('artikel_icons/' . $item->icon_path) }}"
                                    alt="{{ $item->title }} icon" class="w-10 h-10">
                            </div>
                            <h3 class="text-md font-semibold text-gray-900 mb-2">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                {{ Str::limit(strip_tags($item->description), 100) }}</p>
                            <div class="text-right">
                                <a href="{{ route('rekomendasi.show', $item->id) }}"
                                    class="text-sm font-medium text-blue-500 hover:underline">More info</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination links --}}
                <div class="mt-6">
                    {{ $rekomendasis->links() }}
                </div>
            </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Informasi Profil & Aktivitas -->
        <div class="space-y-6">
            <!-- Profil Card -->
            <div class="bg-white/90 rounded-xl shadow-lg p-5">
                <div class="flex items-center mb-4">
                    <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center text-2xl font-bold text-gray-600 mr-4">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-[#0F1A21]">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-600">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="border-t border-gray-200 pt-4 mt-2">
                    <a href="{{ route('profile.edit') }}" class="bg-[#FFA404] text-white px-4 py-2 rounded-lg inline-block hover:bg-[#FF8C00] transition">
                        Edit Profil
                    </a>
                </div>
            </div>
            
            <!-- Aktivitas Terbaru -->
            <div class="bg-white/90 rounded-xl shadow-lg p-5">
                <h2 class="text-xl font-semibold text-[#0F1A21] mb-4">Aktivitas Terbaru</h2>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-800">Login terakhir</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-500 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-800">Laporan banjir terakhir</p>
                            <p class="text-xs text-gray-500">Belum ada laporan</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Nomor Darurat Banjir -->
            <x-emergency-numbers />
        </div>
        
        <!-- Kolom Tengah: Informasi Cuaca & Peringatan -->
        <div class="space-y-6">
           <!-- Informasi Cuaca -->
            <div class="bg-white/90 rounded-xl shadow-lg p-5">
                <h2 class="text-xl font-semibold text-[#0F1A21] mb-4">Informasi Cuaca Hari Ini</h2>

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

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="text-center md:text-left">
                            <div class="text-5xl text-[#FFA404] mb-2">
                                <i class="fas {{ $icon }}"></i>
                            </div>
                            <div class="text-3xl font-bold">{{ number_format($rainfall->rainfall_amount, 2) }} mm</div>
                            <div class="text-gray-700 text-base mt-1">
                                {{ $rainfall->weatherStation->name ?? 'Lokasi tidak diketahui' }}
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ \Carbon\Carbon::parse($rainfall->date)->format('d M Y') }}
                            </p>
                        </div>

                        <div class="border-t md:border-t-0 md:border-l border-gray-300 pt-4 md:pt-0 md:pl-6 space-y-2">
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-tint text-gray-500 mr-2"></i>
                                Curah Hujan: {{ number_format($rainfall->rainfall_amount, 2) }} mm
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-exclamation-circle text-gray-500 mr-2"></i>
                                Kategori: {{ ucfirst($kategori) }}
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 italic">Data cuaca belum tersedia.</p>
                @endif

                <div class="mt-4 text-center">
                    <a href="{{ route('user.weather.dashboard') }}" class="text-[#FFA404] font-medium hover:underline">
                        Lihat prakiraan lengkap
                    </a>
                </div>
            </div>
           <!-- Peringatan Banjir -->
            <div class="bg-white/90 rounded-xl shadow-lg p-5 border-l-4 border-yellow-500">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h2 class="text-xl font-semibold text-[#0F1A21]">Peringatan Dini</h2>
                </div>
                @if(count($peringatanDini) > 0)
                    @foreach($peringatanDini as $peringatan)
                         <p class="text-gray-700 mb-3">Waspad hujan lebat disertai angin kencang di wilayah {{ $peringatan['lokasi'] }} dan sekitarnya dalam 24 jam ke depan.</p>
                        <div class="bg-yellow-50 p-3 rounded-lg mb-2">
                            <div class="flex items-center">
                                <div class="h-2 w-2 rounded-full bg-yellow-500 mr-2"></div>
                                <span class="text-sm font-medium text-yellow-700">
                                     <p class="text-xs text-yellow-600 mt-1">
                                        Status: {{ $peringatan['peringatan'] }}
                                    </p>
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 italic">Tidak ada peringatan dini saat ini.</p>
                @endif
            </div>
        </div>
        
        <!-- Kolom Kanan: Titik Pantau & Tips Banjir -->
        <div class="space-y-6">
            <!-- Titik Pantau Banjir -->
            <div class="bg-white/90 rounded-xl shadow-lg p-5">
                <h2 class="text-xl font-semibold text-[#0F1A21] mb-4">Titik Pantau Banjir</h2>
                <div class="space-y-3">
                    @foreach ($maps as $map)
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
                                    'sangat tinggi' => "<span class='px-2 py-1 bg-red-600 text-white rounded-full text-xs'>Sangat Tinggi</span>",
                                    'tinggi' => "<span class='px-2 py-1 bg-orange-500 text-white rounded-full text-xs'>Tinggi</span>",
                                    'sedang' => "<span class='px-2 py-1 bg-yellow-300 text-gray-800 rounded-full text-xs'>Sedang</span>",
                                    'rendah' => "<span class='px-2 py-1 bg-green-200 text-gray-800 rounded-full text-xs'>Rendah</span>",
                                    default => "<span class='px-2 py-1 bg-gray-300 text-gray-800 rounded-full text-xs'>Tidak diketahui</span>",
                                };
                            }
                        @endphp
                        <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                            <span class="font-medium">{{ $map->wilayah }}</span>
                            <span class="flex gap-1">{!! $badgeHtml !!}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('user.map') }}" class="text-[#FFA404] font-medium hover:underline">Lihat semua titik pantau</a>
                </div>
            </div>

@endsection