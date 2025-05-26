@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-8 mt-10">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Edit Artikel</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.artikels.update', $artikel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
                <input type="text" name="title" id="title" value="{{ old('title', $artikel->title) }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 text-gray-800"
                    required>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Artikel</label>
                <textarea name="description" rows="4"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 text-gray-800" required>{{ old('description', $artikel->description) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Utama Artikel (kosongkan jika tidak
                    ingin mengubah)</label>
                @if ($artikel->image_path)
                    <img src="{{ url('artikel_images/' . $artikel->image_path) }}" alt="Gambar Artikel"
                        class="w-32 h-32 object-cover mb-2">
                @endif
                <input type="file" name="image" class="block w-full text-sm text-gray-600">
            </div>

            <div class="mb-6">
                <label for="icon_path" class="block text-sm font-medium text-gray-700 mb-1">Ikon Artikel (kosongkan jika tidak
                    ingin mengubah)</label>
                @if ($artikel->icon_path)
                    <img src="{{ url('artikel_icons/' . $artikel->icon_path) }}" alt="Ikon Artikel"
                        class="w-12 h-12 object-contain mb-2">
                @endif
                <input type="file" name="icon" class="block w-full text-sm text-gray-600">
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-3">Solusi / Cara</h3>
            <div id="solutions-wrapper" class="space-y-4 text-black">
                @foreach ($artikel->solutions as $solution)
                    <div class="border border-gray-300 bg-gray-50 p-4 rounded-lg">
                        <input type="hidden" name="solution_ids[]" value="{{ $solution->id }}">
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Solusi</label>
                            <input type="text" name="solution_titles[]" value="{{ $solution->title }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Solusi</label>
                            <textarea name="solution_descriptions[]" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm" required>{{ $solution->description }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Ikon (kosongkan jika tidak
                                ingin mengubah)</label>
                            @if ($solution->icon_path)
                                <img src="{{ url('solution_icons/' . $solution->icon_path) }}" alt="Ikon Artikel"
                                    class="w-12 h-12 object-contain mb-2">
                            @endif
                            <input type="file" name="solution_icons[]" class="block w-full text-sm text-gray-600">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-between items-center">
                <a href="{{ route('admin.artikels.index') }}" class="text-gray-600 hover:underline">← Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
