@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 mt-10">
    <div class="bg-gray-100 p-6 rounded-xl shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Artikel</h2>
            <a href="{{ route('admin.artikels.create') }}" class="flex items-center bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-plus mr-2"></i> Tambah Artikel
            </a>
        </div>

        {{-- Header --}}
        <div class="grid grid-cols-5 font-semibold text-gray-700 border-b pb-3 mb-3">
            <div>Judul</div>
            <div>Deskripsi</div>
            <div>Gambar Artikel</div>
            <div>Icon Path</div>
            <div>Aksi</div>
        </div>

        {{-- List Artikel --}}
        @foreach ($artikels as $artikel)
            <div class="grid grid-cols-5 items-center bg-white p-4 mb-3 rounded-lg shadow-sm">
                {{-- Judul --}}
                <div class="text-gray-800 font-medium">
                    {{ $artikel->title }}
                </div>

                {{-- Deskripsi --}}
                <div class="text-sm text-gray-600">
                    {{ $artikel->description }}
                </div>

                {{-- Gambar Artikel --}}
                <div>
                    @if ($artikel->image_path)
                        <img src="{{ url('artikel_images/' . $artikel->image_path) }}" class="w-20 h-20 object-cover rounded" alt="gambar">
                    @else
                        <span class="text-sm text-gray-500">Tidak Ada</span>
                    @endif
                </div>

                {{-- Icon Path --}}
                <div class="flex gap-2 flex-wrap">
                    @foreach ($artikel->solutions as $solution)
                        @if ($solution->icon_path)
                            <img src="{{ url('solution_icons/' . $solution->icon_path) }}" class="w-6 h-6 rounded-full" alt="icon">
                        @endif
                    @endforeach
                </div>

                {{-- Aksi --}}
                <div class="flex gap-2">
                    <a href="{{ route('admin.artikels.edit', $artikel) }}" class="bg-yellow-400 text-black px-3 py-1 rounded flex items-center">
                        <i class="fas fa-pen mr-1"></i>Edit
                    </a>
                    <form action="{{ route('admin.artikels.destroy', $artikel) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin ingin hapus artikel ini?')" class="bg-red-600 text-white px-3 py-1 rounded flex items-center">
                            <i class="fas fa-trash mr-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
