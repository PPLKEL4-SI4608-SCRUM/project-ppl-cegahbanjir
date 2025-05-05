@extends('layouts.app')

@section('content')
    @php use Illuminate\Support\Str; @endphp

    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="bg-white/80 p-8 rounded-2xl shadow-xl backdrop-blur-md">
            <h1 class="text-2xl font-bold mb-2">Selamat datang, Pengguna CeBan!</h1>
            <p class="mb-6 text-gray-700">Ini adalah Halaman dashboard untuk pengguna <strong>CeBan</strong> (Cegah Banjir).
            </p>

            {{-- 🔗 Quick Links --}}
            <h2 class="text-lg font-semibold mt-6 mb-4">Quick Links</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-bold text-gray-800">Laporan Bencana</h3>
                    <p class="text-sm text-gray-600 mt-1">Input & pantau laporan kejadian banjir</p>
                    <a href="{{ route('laporan.index') }}"
                        class="mt-4 inline-block bg-yellow-400 text-white font-semibold px-4 py-2 rounded hover:bg-yellow-500">Akses</a>
                </div>
            </div>

            {{-- ✨ Rekomendasi Artikel Banjir --}}
            <div class="mt-16">
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
        </div>
    </div>
@endsection
