@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto bg-white bg-opacity-80 backdrop-blur-md shadow-lg rounded-2xl p-8 mt-10 text-gray-800">
        <h2 class="text-3xl font-bold mb-6 text-gray-800 border-b-2 border-gray-200 pb-4">Tambah Riwayat Banjir</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 shadow-sm">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.flood_history.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="location" id="location"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-[#FFA404] focus:border-[#FFA404] text-gray-800 p-2.5"
                       value="{{ old('location') }}" required>
            </div>

            <div class="mb-6">
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kejadian</label>
                <input type="date" name="date" id="date"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-[#FFA404] focus:border-[#FFA404] text-gray-800 p-2.5"
                       value="{{ old('date') }}" required>
            </div>

            <div class="mb-6">
                <label for="impact" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Dampak / Kejadian</label>
                <textarea name="impact" id="impact" rows="4"
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-[#FFA404] focus:border-[#FFA404] text-gray-800 p-2.5"
                          required>{{ old('impact') }}</textarea>
            </div>

            <div class="mb-6">
                <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Gambar Utama</label>
                <div class="custom-file-input-wrapper">
                    {{-- This is the actual hidden file input --}}
                    <input type="file" name="images" id="images" accept="image/*" class="custom-file-input hidden">

                    {{-- This label is what the user sees and clicks --}}
                    <label for="images" class="custom-file-label">
                        <i class="fas fa-upload mr-2 text-gray-400"></i>
                        <span id="file-name" class="flex-grow text-left">No file chosen</span>
                    </label>
                </div>
                <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF, or SVG (Max 2MB)</p>
            </div>

            <div class="mt-8 flex justify-end items-center gap-4">
                <a href="{{ route('admin.flood_history.index') }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-6 rounded-lg transition shadow-md flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit" class="bg-[#FFA404] hover:bg-[#e69400] text-white font-semibold py-2.5 px-6 rounded-lg transition shadow-md">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const fileInput = document.getElementById('images');
                const fileNameSpan = document.getElementById('file-name');

                // Set initial text
                fileNameSpan.textContent = 'No file chosen';

                fileInput.addEventListener('change', function(event) {
                    if (event.target.files.length > 0) {
                        fileNameSpan.textContent = event.target.files[0].name;
                    } else {
                        fileNameSpan.textContent = 'No file chosen'; // Revert if no file selected
                    }
                });
            });
        </script>
    @endsection
@endsection