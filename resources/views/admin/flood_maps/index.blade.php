@extends('layouts.admin')

@section('title', 'Manajemen Peta Interaktif')

@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-3xl font-bold text-white">Manajemen Peta Interaktif</h1>
    <a href="{{ route('admin.flood-maps.create') }}" class="bg-[#FFA404] hover:bg-[#ff8c00] text-white px-6 py-2 rounded-full">
        + Tambah Wilayah
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($floodMaps as $map)
    <div class="bg-[#0F1A21]/80 p-4 rounded-lg shadow-lg">
        <!-- Gambar -->
        @if ($map->gambar)
            <img src="{{ asset('storage/' . $map->gambar) }}" class="w-full h-[500px] object-cover rounded mb-4" alt="{{ $map->wilayah }}">
        @else
            <div class="w-full h-[500px] bg-gray-700 flex items-center justify-center text-white mb-4 rounded">
                Tidak ada gambar
            </div>
        @endif

        <!-- Info Wilayah -->
        <h2 class="text-xl font-semibold text-white mb-2">{{ $map->wilayah }}</h2>
        <p class="text-sm text-gray-300">Lat: {{ $map->latitude }}, Lng: {{ $map->longitude }}</p>

        <!-- Tombol Aksi -->
        <div class="flex space-x-2 mt-4">
            <a href="{{ route('admin.flood-maps.edit', $map) }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">Edit</a>
            <form action="{{ route('admin.flood-maps.destroy', $map) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
