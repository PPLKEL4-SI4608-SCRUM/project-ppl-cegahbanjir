@extends('layouts.admin')

@section('title', 'Manajemen Data Curah Hujan')

@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manajemen Data Curah Hujan</h1>
        <a href="{{ route('admin.weather.rainfall.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#f97316] rounded hover:bg-[#ea580c]">
            <i class="fas fa-plus mr-2"></i> Tambah Data
        </a>
    </div>

<div class="bg-white shadow rounded-lg p-6 mb-10">
    @if($rainfallData->isEmpty())
        <div class="text-[#92400e] bg-[#ffedd5] p-4 rounded">
            Belum ada data curah hujan yang tersedia. Silakan tambahkan data baru.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">Stasiun</th>
                        <th class="px-4 py-2 text-left font-semibold">Tanggal & Waktu</th>
                        <th class="px-4 py-2 text-left font-semibold">Curah Hujan (mm)</th>
                        <th class="px-4 py-2 text-left font-semibold">Intensitas (mm/jam)</th>
                        <th class="px-4 py-2 text-left font-semibold">Sumber Data</th>
                        <th class="px-4 py-2 text-left font-semibold">Ditambahkan Oleh</th>
                        <th class="px-4 py-2 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($rainfallData as $data)
                        <tr>
                            <td class="px-4 py-2">{{ $data->weatherStation->name }}</td>
                            <td class="px-4 py-2">{{ $data->recorded_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2">{{ $data->rainfall_amount }}</td>
                            <td class="px-4 py-2">{{ $data->intensity ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @if($data->data_source == 'manual')
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-gray-500 rounded">Manual</span>
                                @elseif($data->data_source == 'api')
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-[#f97316] rounded">API</span>
                                @else
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-indigo-500 rounded">Sensor</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $data->addedBy->name }}</td>
                            <td class="px-4 py-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.weather.rainfall.edit', $data) }}" class="inline-flex items-center px-2 py-1 text-xs text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.weather.rainfall.destroy', $data) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
            {{ $rainfallData->links() }}
        </div>
    @endif
</div>
@endsection