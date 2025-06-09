@extends('layouts.admin')

@section('title', 'Kelola Laporan Bencana')

@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-10">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">Kelola Laporan Bencana</h1>
  </div>

  @if(session('success'))
    <div class="text-green-700 bg-green-100 p-4 rounded mb-6">
      {{ session('success') }}
    </div>
  @endif

  @if($reports->isEmpty())
    <div class="text-[#92400e] bg-[#ffedd5] p-4 rounded">
      Belum ada laporan bencana yang masuk.
    </div>
  @else
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-2 text-left font-semibold">Pelapor</th>
            <th class="px-4 py-2 text-left font-semibold">Lokasi</th>
            <th class="px-4 py-2 text-left font-semibold">Deskripsi</th>
            <th class="px-4 py-2 text-left font-semibold">Gambar</th>
            <th class="px-4 py-2 text-left font-semibold">Status</th>
            <th class="px-4 py-2 text-left font-semibold">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($reports as $report)
            <tr>
              <td class="px-4 py-2">{{ $report->user->name }}</td>
              <td class="px-4 py-2">{{ $report->location }}</td>
              <td class="px-4 py-2">{{ $report->description }}</td>
              <td class="px-4 py-2">
                @if($report->disaster_image)
                  <img src="{{ asset('disaster_images/' . $report->disaster_image) }}" class="w-24 h-16 object-cover rounded shadow" alt="Bukti Bencana">
                @else
                  <span class="italic text-gray-400">Tidak ada gambar</span>
                @endif
              </td>
              <td class="px-4 py-2">
                @if($report->status == 'pending')
                  <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-yellow-500 rounded">Pending</span>
                @else
                  <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-green-600 rounded capitalize">{{ $report->status }}</span>
                @endif
              </td>
              <td class="px-4 py-2">
                @if($report->status == 'pending')
                  <div class="flex space-x-2">
                    <form action="{{ route('admin.disaster-reports.accept', $report->id) }}" method="POST" class="inline">
                      @csrf @method('PATCH')
                      <button type="submit" class="inline-flex items-center px-2 py-1 text-xs text-white bg-green-600 rounded hover:bg-green-700">
                        <i class="fas fa-check mr-1"></i> Terima
                      </button>
                    </form>
                    <form action="{{ route('admin.disaster-reports.reject', $report->id) }}" method="POST" class="inline">
                      @csrf @method('PATCH')
                      <button type="submit" class="inline-flex items-center px-2 py-1 text-xs text-white bg-red-600 rounded hover:bg-red-700">
                        <i class="fas fa-times mr-1"></i> Tolak
                      </button>
                    </form>
                  </div>
                @else
                  <span class="italic text-gray-500">Sudah diproses</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
