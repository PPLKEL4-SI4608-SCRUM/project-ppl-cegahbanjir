@extends('layouts.admin')

@section('title', 'Manajemen Peta Banjir')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-white">Manajemen Peta</h1>
    <a href="{{ route('admin.flood-maps.create') }}" class="bg-[#FFA404] text-white px-4 py-2 rounded mt-4 inline-block">
        + Tambah Wilayah
    </a>
</div>

@if(session('success'))
    <div class="bg-green-600 text-white p-3 rounded mb-4">
        {{ session('success') }}
        @php session()->forget('success'); @endphp
    </div>
@endif

<table class="w-full bg-[#0F1A21]/90 text-white rounded shadow overflow-hidden">
    <thead class="bg-[#1a2a38]">
        <tr>
            <th class="p-3 text-left">Wilayah</th>
            <th class="p-3 text-center">Tingkat Risiko</th>
            <th class="p-3 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($floodMaps as $map)
        <tr class="border-t border-gray-700">
            <td class="p-3">{{ $map->wilayah }}</td>
            <td class="p-3 text-center">
                @php
                    // Pastikan polygons sudah array
                    $poly = is_string($map->polygons) ? json_decode($map->polygons, true) : $map->polygons;

                    // Ambil semua risiko unik yang valid
                    $risikos = collect($poly)
                        ->pluck('tingkat_risiko')
                        ->filter()
                        ->map(fn($r) => ucfirst($r))
                        ->unique()
                        ->implode(', ');
                @endphp
                {{ $risikos ?: '-' }}
            </td>
            <td class="p-3 text-center">
                <a href="{{ route('admin.flood-maps.edit', $map) }}" class="bg-yellow-500 px-3 py-1 rounded">Edit</a>
                <form action="{{ route('admin.flood-maps.destroy', $map) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 px-3 py-1 rounded" onclick="return confirm('Hapus data ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="p-3 text-center text-gray-300">Belum ada data wilayah banjir.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
