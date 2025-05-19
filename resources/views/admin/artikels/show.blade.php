@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-6 mt-10">
    <div class="bg-white p-6 rounded-xl shadow-md">
        {{-- Judul Artikel --}}
        <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ $artikel->title }}</h2>

        {{-- Deskripsi Artikel --}}
        <p class="text-gray-700 text-sm mb-6">{{ $artikel->description }}</p>

        {{-- Gambar Utama --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Gambar Artikel</h3>
            @if ($artikel->image_path)
                <img src="{{ asset('storage/' . $artikel->image_path) }}" alt="Gambar Artikel" class="w-full max-w-md rounded-lg shadow-sm">
            @else
                <p class="text-gray-500 text-sm">Tidak ada gambar diunggah.</p>
            @endif
        </div>

        {{-- Solusi --}}
        <div class="mt-8">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Solusi / Cara</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($artikel->solutions as $solution)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                        @if ($solution->icon_path)
                            <img src="{{ asset('storage/' . $solution->icon_path) }}" alt="Icon" class="w-12 h-12 object-contain mb-2">
                        @endif
                        <h4 class="font-semibold text-gray-800 text-sm mb-1">{{ $solution->title }}</h4>
                        <p class="text-sm text-gray-600">{{ $solution->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('admin.artikels.index') }}" class="inline-block text-sm text-blue-600 hover:underline">
                ← Kembali ke Daftar Artikel
            </a>
        </div>
    </div>
</div>
@endsection
