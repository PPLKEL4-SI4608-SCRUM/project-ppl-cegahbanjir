@extends('layouts.admin')

@section('title', 'Manajemen Peta Banjir')

@section('content')
<div class="bg-white/70 backdrop-blur-md min-h-screen p-6 rounded-2xl shadow-xl">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-black">Manajemen Prediksi Wilayah Banjir</h1>
        <a href="{{ route('admin.flood-maps.create') }}" class="mt-4 inline-flex items-center gap-2 bg-[#FFA404] hover:bg-[#e89402] text-white px-4 py-2 rounded-xl shadow transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Wilayah
        </a>
    </div>

    @if(session('success'))
        <div class="mt-4 p-4 rounded-xl bg-green-500/80 text-white font-semibold shadow">
            {{ session('success') }}
            @php session()->forget('success'); @endphp
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-6">
        <table class="w-full text-[#0F1A21]">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 text-left font-semibold">Wilayah</th>
                    <th class="p-4 text-center font-semibold">Tingkat Risiko</th>
                    <th class="p-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($floodMaps as $map)
                <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                    <td class="p-4">{{ $map->wilayah }}</td>
                    <td class="p-4 text-center">
                        @php
                            $poly = is_string($map->polygons) ? json_decode($map->polygons, true) : $map->polygons;
                            $risikos = collect($poly)
                                ->pluck('tingkat_risiko')
                                ->filter()
                                ->map(fn($r) => ucfirst($r))
                                ->unique()
                                ->implode(', ');
                        @endphp
                        {{ $risikos ?: '-' }}
                    </td>
                    <td class="p-4 text-center space-x-2">
                        <a href="{{ route('admin.flood-maps.edit', $map) }}" class="bg-yellow-400 hover:bg-yellow-300 text-black px-4 py-1 rounded-xl transition">Edit</a>
                        <form action="{{ route('admin.flood-maps.destroy', $map) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus data ini?')" class="bg-red-500 hover:bg-red-400 text-white px-4 py-1 rounded-xl transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500">Belum ada data wilayah banjir.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
