@extends('layouts.admin')
@section('title', 'Manajemen Prediksi Banjir')
@section('content')
    <div class="bg-white shadow rounded-lg p-6 mb-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Manajemen Prediksi Banjir</h1>
            <a href="{{ route('admin.weather.predictions.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#f97316] rounded hover:bg-[#ea580c]">
                <i class="fas fa-plus mr-2"></i> Tambah Prediksi
            </a>
        </div>

    <div class="bg-white shadow rounded-lg p-6 mb-10">
        @if($predictions->isEmpty())
            <div class="text-[#92400e] bg-[#ffedd5] p-4 rounded">
                Belum ada data prediksi banjir. Silakan tambahkan prediksi baru.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">Stasiun</th>
                            <th class="px-4 py-2">Tanggal Prediksi</th>
                            <th class="px-4 py-2">Tingkat Risiko</th>
                            <th class="px-4 py-2">Prediksi Curah Hujan</th>
                            <th class="px-4 py-2">Dibuat Oleh</th>
                            <th class="px-4 py-2">Dibuat Pada</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($predictions as $prediction)
                            <tr>
                                <td class="px-4 py-2">{{ $prediction->weatherStation->name }}</td>
                                <td class="px-4 py-2">{{ $prediction->prediction_date->format('d M Y') }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $badgeColor = [
                                            'rendah' => 'bg-green-100 text-green-800',
                                            'sedang' => 'bg-yellow-100 text-yellow-800',
                                            'tinggi' => 'bg-red-100 text-red-800',
                                            'sangat_tinggi' => 'bg-gray-200 text-gray-800'
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded {{ $badgeColor[$prediction->risk_level] ?? 'bg-gray-200 text-gray-800' }}">
                                        {{ ucfirst(str_replace('_', ' ', $prediction->risk_level)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $prediction->predicted_rainfall ?? '-' }} mm</td>
                                <td class="px-4 py-2">{{ $prediction->createdBy->name }}</td>
                                <td class="px-4 py-2">{{ $prediction->created_at->format('d M Y H:i') }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{ route('admin.weather.predictions.edit', $prediction) }}" class="inline-flex items-center px-2 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.weather.predictions.destroy', $prediction) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus prediksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700">
                                            <i class="fas fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $predictions->links() }}
            </div>
        @endif
    </div>
@endsection