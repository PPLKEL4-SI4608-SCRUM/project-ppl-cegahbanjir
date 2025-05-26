@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto bg-white bg-opacity-80 backdrop-blur-md shadow-lg rounded-2xl p-8 mt-10 text-gray-800">
        <h2 class="text-3xl font-bold mb-6 text-gray-800 border-b-2 border-gray-200 pb-4">Edit Riwayat Banjir</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 shadow-sm">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form action is corrected to use the 'update' method --}}
        <form action="{{ route('admin.flood_history.update', $flood->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Essential for update operations --}}

            <div class="mb-6">
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="location" id="location"
                       value="{{ old('location', $flood->location) }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-[#FFA404] focus:border-[#FFA404] text-gray-800 p-2.5"
                       required>
            </div>

            <div class="mb-6">
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kejadian</label>
                <input type="date" name="date" id="date"
                       value="{{ old('date', $flood->date) }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-[#FFA404] focus:border-[#FFA404] text-gray-800 p-2.5"
                       required>
            </div>

            <div class="mb-6">
                <label for="impact" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Dampak / Kejadian</label>
                <textarea name="impact" id="impact" rows="4"
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-[#FFA404] focus:border-[#FFA404] text-gray-800 p-2.5"
                              required>{{ old('impact', $flood->impact) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Gambar Banjir (kosongkan jika tidak mengubah)</label>
                @if ($flood->images)
                    <div class="mb-3">
                        <p class="text-sm text-gray-600 mb-1">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $flood->images) }}" alt="Gambar Banjir"
                             class="w-32 h-32 object-cover rounded-lg border border-gray-200 shadow-sm">
                    </div>
                @endif
                {{-- Custom file input UI --}}
                <div class="custom-file-input-wrapper">
                    <input type="file" name="images" id="images" accept="image/*" class="custom-file-input hidden">
                    <label for="images" class="custom-file-label">
                        <i class="fas fa-upload mr-2 text-gray-400"></i>
                        <span id="file-name" class="flex-grow text-left">Pilih file baru...</span>
                    </label>
                </div>
                <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF, or SVG (Max 2MB)</p>
            </div>

            <div class="mt-8 flex justify-end items-center gap-4">
                {{-- Changed cancel link to match the orange theme's visual style --}}
                <a href="{{ route('admin.flood_history.index') }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-6 rounded-lg transition shadow-md flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit" class="bg-[#FFA404] hover:bg-[#e69400] text-white font-semibold py-2.5 px-6 rounded-lg transition shadow-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
{{-- Custom styling for the file input to make it look nicer with Tailwind --}}
<style>
    .custom-file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }
    .custom-file-label {
        background-color: #f9fafb; /* Light gray background */
        border: 1px solid #d1d5db; /* Gray border */
        border-radius: 0.5rem; /* Rounded corners */
        padding: 0.625rem 1rem; /* Padding */
        display: flex; /* Use flexbox for icon and text alignment */
        align-items: center; /* Center items vertically */
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* Subtle shadow */
        color: #4b5563; /* Darker text color */
    }
    .custom-file-label:hover {
        background-color: #e5e7eb; /* Slightly darker on hover */
        border-color: #9ca3af; /* Darker border on hover */
    }
    .custom-file-input:focus + .custom-file-label {
        border-color: #FFA404; /* Focus color matching your theme */
        box-shadow: 0 0 0 3px rgba(255, 164, 4, 0.3); /* Focus ring */
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('images');
        const fileNameSpan = document.getElementById('file-name');

        // Set initial text based on if an old image exists or not
        if ("{{ old('images', $flood->images) }}") {
            // If there's an existing image (either old input or from DB), show current file name or generic text
            fileNameSpan.textContent = 'Gambar sudah ada, pilih untuk mengubah';
        } else {
            fileNameSpan.textContent = 'Pilih file baru...';
        }

        fileInput.addEventListener('change', function(event) {
            if (event.target.files.length > 0) {
                fileNameSpan.textContent = event.target.files[0].name;
            } else {
                // If user opens dialog but cancels, revert text based on if image existed before
                if ("{{ old('images', $flood->images) }}") {
                    fileNameSpan.textContent = 'Gambar sudah ada, pilih untuk mengubah';
                } else {
                    fileNameSpan.textContent = 'Pilih file baru...';
                }
            }
        });
    });
</script>
@endpush