@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-xl p-8 mt-10">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Edit Riwayat Banjir</h2> {{-- Changed title to Indonesian --}}

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- CORRECTED FORM ACTION HERE --}}
        <form action="{{ route('admin.flood_history.edit', $flood->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- This is correctly included for update operations --}}

            <div class="mb-6">
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="location" id="location"
                       value="{{ old('location', $flood->location) }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 text-gray-800"
                       required>
            </div>

            <div class="mb-6">
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kejadian</label> {{-- Clarified label text --}}
                <input type="date" name="date" id="date"
                       value="{{ old('date', $flood->date) }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 text-gray-800"
                       required>
            </div>

            <div class="mb-6">
                <label for="impact" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Dampak / Kejadian</label> {{-- Clarified label text --}}
                <textarea name="impact" id="impact" rows="4"
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 text-gray-800"
                              required>{{ old('impact', $flood->impact) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Gambar Banjir (kosongkan jika tidak mengubah)</label>
                @if ($flood->images)
                    <img src="{{ asset('storage/' . $flood->images) }}" alt="Gambar Banjir"
                         class="w-32 h-32 object-cover mb-2 rounded">
                @endif
                {{-- Added ID for input consistency --}}
                <input type="file" name="images" id="images" accept="image/*" class="block w-full text-sm text-gray-600">
            </div>

            <div class="mt-8 flex justify-between items-center">
                {{-- CORRECTED CANCEL LINK HERE --}}
                <a href="{{ route('admin.flood_history.index') }}" class="text-gray-600 hover:underline">← Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection