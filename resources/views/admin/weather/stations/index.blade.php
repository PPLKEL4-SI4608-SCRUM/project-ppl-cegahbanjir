@extends('layouts.admin')

@section('title', 'Manajemen Stasiun Cuaca')

@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manajemen Stasiun Cuaca</h1>
        <a href="{{ route('admin.weather.stations.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#f97316] rounded hover:bg-[#ea580c]">
            <i class="fas fa-plus mr-2"></i> Tambah Stasiun
        </a>
    </div>

<div class="bg-white shadow rounded-lg p-6 mb-10">
    @if($stations->isEmpty())
        <div class="text-[#92400e] bg-[#ffedd5] p-4 rounded">
            Belum ada stasiun cuaca yang terdaftar. Silakan tambahkan stasiun baru.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">Nama</th>
                        <th class="px-4 py-2 text-left font-semibold">Lokasi</th>
                        <th class="px-4 py-2 text-left font-semibold">Koordinat</th>
                        <th class="px-4 py-2 text-left font-semibold">Status</th>
                        <th class="px-4 py-2 text-left font-semibold">Terakhir Diperbarui</th>
                        <th class="px-4 py-2 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($stations as $station)
                        <tr>
                            <td class="px-4 py-2">{{ $station->name }}</td>
                            <td class="px-4 py-2">{{ $station->location }}</td>
                            <td class="px-4 py-2">{{ $station->latitude }}, {{ $station->longitude }}</td>
                            <td class="px-4 py-2">
                                @if($station->status == 'active')
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded">Aktif</span>
                                @elseif($station->status == 'maintenance')
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-yellow-500 rounded">Pemeliharaan</span>
                                @else
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $station->updated_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.weather.stations.edit', $station) }}" class="inline-flex items-center px-2 py-1 text-xs text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.weather.stations.destroy', $station) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus stasiun ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-2 py-1 text-xs text-white bg-red-600 rounded hover:bg-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $stations->links() }}
        </div>
    @endif
</div>
@endsection
