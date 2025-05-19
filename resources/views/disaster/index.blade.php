@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">Laporan Kejadian Bencana</h1>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Tambah Laporan --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Tambah Laporan Baru</h2>
        <form method="POST" action="{{ route('laporan.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="location" class="block text-gray-600 font-medium">Lokasi Kejadian</label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">
                @error('location')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-gray-600 font-medium">Deskripsi Kejadian</label>
                <textarea id="description" name="description" rows="3" required
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-gray-600 font-medium">Status</label>
                <select id="status" name="status" required
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">
                    <option value="">Pilih Status</option>
                    <option value="rejected" @selected(old('status') == 'rejected')>Merah (Rejected)</option>
                    <option value="pending" @selected(old('status') == 'pending')>Kuning (Pending)</option>
                    <option value="approved" @selected(old('status') == 'approved')>Biru (Approved)</option>
                </select>
                @error('status')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Simpan Laporan
                </button>
            </div>
        </form>
    </div>

    {{-- Riwayat Laporan --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Riwayat Laporan</h2>

        @if ($reports->isEmpty())
            <p class="text-gray-600">Belum ada laporan yang tersedia.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Nama Pelapor</th>
                            <th class="px-4 py-2 border">Lokasi</th>
                            <th class="px-4 py-2 border">Deskripsi</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $index => $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border">{{ $report->user->name ?? 'Tidak diketahui' }}</td>
                                <td class="px-4 py-2 border">{{ $report->location }}</td>
                                <td class="px-4 py-2 border">{{ $report->description }}</td>
                                <td class="px-4 py-2 border">
                                    @if ($report->status == 'rejected')
                                        <span class="text-red-600 font-semibold">Rejected</span>
                                    @elseif ($report->status == 'pending')
                                        <span class="text-yellow-600 font-semibold">Pending</span>
                                    @else
                                        <span class="text-blue-600 font-semibold">Approved</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">{{ $report->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-4 py-2 border">
                                    <button data-modal-target="default-modal{{ $report->id }}"
                                            data-modal-toggle="default-modal{{ $report->id }}"
                                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Detail
                                    </button>
                                    <form action="{{ route('laporan.destroy', $report->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Hapus
                                        </button>
                                    </form>
                                    <button data-modal-target="default-modal{{ $report->id }}"
                                            data-modal-toggle="default-modal{{ $report->id }}"
                                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Detail
                                    </button>
                                    <form action="{{ route('laporan.destroy', $report->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Hapus
                                        </button>
                                    </form>
                                    <button data-modal-target="default-modal{{ $report->id }}"
                                            data-modal-toggle="default-modal{{ $report->id }}"
                                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Detail
                                    </button>
                                </td>
                            </tr>

                            {{-- Modal Detail --}}
                            @include('partials.modal-detail', ['report' => $report])
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection