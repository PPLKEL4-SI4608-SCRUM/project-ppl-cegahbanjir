@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 mt-10">
    <h2 class="text-3xl font-extrabold text-white mb-6 drop-shadow">Kelola Laporan Bencana</h2>

    @if(session('success'))
        <div class="bg-green-500 text-white px-4 py-3 rounded-lg shadow mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white/90 backdrop-blur rounded-xl shadow-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-700 text-sm font-semibold uppercase">
                <tr>
                    <th class="py-4 px-6">Pelapor</th>
                    <th class="py-4 px-6">Lokasi</th>
                    <th class="py-4 px-6">Deskripsi</th>
                    <th class="py-4 px-6">Gambar</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-800">
                @foreach($reports as $report)
                <tr class="border-b hover:bg-gray-50 transition duration-200">
                    <td class="py-4 px-6">{{ $report->user->name }}</td>
                    <td class="py-4 px-6">{{ $report->location }}</td>
                    <td class="py-4 px-6">{{ $report->description }}</td>
                    <td class="py-4 px-6">
                        @if($report->disaster_image)
                            <img src="{{ asset('disaster_images/' . $report->disaster_image) }}" class="w-24 h-16 object-cover rounded shadow" alt="Bukti Bencana">
                        @else
                            <span class="italic text-gray-400">Tidak ada gambar</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 capitalize">
                        <span class="px-2 py-1 rounded text-white {{ $report->status == 'pending' ? 'bg-yellow-500' : 'bg-green-600' }}">
                            {{ $report->status }}
                        </span>
                    </td>
                    <td class="py-4 px-6 space-x-2">
                        @if($report->status == 'pending')
                            <form action="{{ route('admin.disaster-reports.accept', $report->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded shadow">
                                    Terima
                                </button>
                            </form>
                            <form action="{{ route('admin.disaster-reports.reject', $report->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow">
                                    Tolak
                                </button>
                            </form>
                        @else
                            <span class="italic text-gray-500">Sudah diproses</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
