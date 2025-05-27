@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-8 mt-10">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Tambah Artikel Rekomendasi</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.artikels.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
            <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 text-gray-800" required>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Artikel</label>
            <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 text-gray-800" required></textarea>
        </div>

        {{-- Gambar Utama Artikel --}}
        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Utama Artikel</label>
            <div class="relative flex items-center border border-gray-300 rounded-lg shadow-sm p-2 pr-4">
                <label for="image" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white text-sm py-2 px-4 rounded-md inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                    </svg>
                    Pilih Gambar
                    <input type="file" name="image" id="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                </label>
                <span id="image-filename" class="ml-3 text-gray-600 text-sm truncate">Tidak ada file dipilih</span>
            </div>
        </div>

        {{-- Ikon Utama Artikel --}}
        <div class="mb-6">
            <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Ikon Utama Artikel</label>
            <div class="relative flex items-center border border-gray-300 rounded-lg shadow-sm p-2 pr-4">
                <label for="icon" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white text-sm py-2 px-4 rounded-md inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM2.343 14.243a1 1 0 001.414 1.414l.707-.707a1 1 0 00-1.414-1.414l-.707.707zM4 10a1 1 0 01-1 1H2a1 1 0 110-2h1a1 1 0 011 1zM10 18a1 1 0 00-1 1v1a1 1 0 102 0v-1a1 1 0 00-1-1zM5.757 4.343a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zm12.728 12.728a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM10 5a1 1 0 00-1 1v2a1 1 0 102 0V6a1 1 0 00-1-1zM6 10a1 1 0 01-1 1H3a1 1 0 110-2h2a1 1 0 011 1zm4 2a1 1 0 100 2h2a1 1 0 100-2h-2zm-3 4a1 1 0 00-1 1v2a1 1 0 102 0v-2a1 1 0 00-1-1z" />
                    </svg>
                    Pilih Ikon
                    <input type="file" name="icon" id="icon" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                </label>
                <span id="icon-filename" class="ml-3 text-gray-600 text-sm truncate">Tidak ada file dipilih</span>
            </div>
        </div>


        <h3 class="text-xl font-semibold text-gray-800 mb-3">Solusi / Cara</h3>
        <div id="solution-container" class="space-y-4">
            <div class="border border-gray-300 bg-gray-50 p-4 rounded-lg">
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Solusi</label>
                    <input type="text" name="solution_titles[]" class="w-full border border-gray-300 rounded-lg shadow-sm text-gray-800" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Solusi</label>
                    <textarea name="solution_descriptions[]" rows="2" class="w-full border border-gray-300 rounded-lg shadow-sm text-gray-800" required></textarea>
                </div>
                {{-- Upload Ikon Solusi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Ikon Solusi</label>
                    <div class="relative flex items-center border border-gray-300 rounded-lg shadow-sm p-2 pr-4">
                        <label class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white text-sm py-2 px-4 rounded-md inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM2.343 14.243a1 1 0 001.414 1.414l.707-.707a1 1 0 00-1.414-1.414l-.707.707zM4 10a1 1 0 01-1 1H2a1 1 0 110-2h1a1 1 0 011 1zM10 18a1 1 0 00-1 1v1a1 1 0 102 0v-1a1 1 0 00-1-1zM5.757 4.343a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zm12.728 12.728a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM10 5a1 1 0 00-1 1v2a1 1 0 102 0V6a1 1 0 00-1-1zM6 10a1 1 0 01-1 1H3a1 1 0 110-2h2a1 1 0 011 1zm4 2a1 1 0 100 2h2a1 1 0 100-2h-2zm-3 4a1 1 0 00-1 1v2a1 1 0 102 0v-2a1 1 0 00-1-1z" />
                            </svg>
                            Pilih Ikon
                            <input type="file" name="solution_icons[]" class="absolute inset-0 opacity-0 cursor-pointer solution-icon-input">
                        </label>
                        <span class="ml-3 text-gray-600 text-sm truncate solution-icon-filename">Tidak ada file dipilih</span>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" id="add-solution" class="mt-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
            + Tambah Solusi
        </button>

        <div class="mt-8 flex justify-between items-center">
            <a href="{{ route('admin.artikels.index') }}" class="text-gray-600 hover:underline">← Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg">
                Simpan Artikel
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to update filename display
        function updateFileName(inputElement, filenameSpan) {
            if (inputElement.files.length > 0) {
                filenameSpan.textContent = inputElement.files[0].name;
            } else {
                filenameSpan.textContent = 'Tidak ada file dipilih';
            }
        }

        // Attach event listener for Gambar Utama Artikel
        const imageInput = document.getElementById('image');
        const imageFilenameSpan = document.getElementById('image-filename');
        imageInput.addEventListener('change', function() {
            updateFileName(this, imageFilenameSpan);
        });

        // Attach event listener for Ikon Utama Artikel
        const iconInput = document.getElementById('icon');
        const iconFilenameSpan = document.getElementById('icon-filename');
        iconInput.addEventListener('change', function() {
            updateFileName(this, iconFilenameSpan);
        });

        // Add Solution button logic
        document.getElementById('add-solution').addEventListener('click', function () {
            const container = document.getElementById('solution-container');
            const newSolutionDiv = document.createElement('div');
            newSolutionDiv.className = 'border border-gray-300 bg-gray-50 p-4 rounded-lg mt-4';
            newSolutionDiv.innerHTML = `
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Solusi</label>
                    <input type="text" name="solution_titles[]" class="w-full border border-gray-300 rounded-lg shadow-sm text-gray-800" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Solusi</label>
                    <textarea name="solution_descriptions[]" rows="2" class="w-full border border-gray-300 rounded-lg shadow-sm text-gray-800" required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Ikon Solusi</label>
                    <div class="relative flex items-center border border-gray-300 rounded-lg shadow-sm p-2 pr-4">
                        <label class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white text-sm py-2 px-4 rounded-md inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM2.343 14.243a1 1 0 001.414 1.414l.707-.707a1 1 0 00-1.414-1.414l-.707.707zM4 10a1 1 0 01-1 1H2a1 1 0 110-2h1a1 1 0 011 1zM10 18a1 1 0 00-1 1v1a1 1 0 102 0v-1a1 1 0 00-1-1zM5.757 4.343a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zm12.728 12.728a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM10 5a1 1 0 00-1 1v2a1 1 0 102 0V6a1 1 0 00-1-1zM6 10a1 1 0 01-1 1H3a1 1 0 110-2h2a1 1 0 011 1zm4 2a1 1 0 100 2h2a1 1 0 100-2h-2zm-3 4a1 1 0 00-1 1v2a1 1 0 102 0v-2a1 1 0 00-1-1z" />
                            </svg>
                            Pilih Ikon
                            <input type="file" name="solution_icons[]" class="absolute inset-0 opacity-0 cursor-pointer solution-icon-input">
                        </label>
                        <span class="ml-3 text-gray-600 text-sm truncate solution-icon-filename">Tidak ada file dipilih</span>
                    </div>
                </div>
            `;
            container.appendChild(newSolutionDiv);

            // Attach change listener to the newly added file input
            const newIconInput = newSolutionDiv.querySelector('.solution-icon-input');
            const newIconFilenameSpan = newSolutionDiv.querySelector('.solution-icon-filename');
            newIconInput.addEventListener('change', function() {
                updateFileName(this, newIconFilenameSpan);
            });
        });
    });
</script>
@endsection