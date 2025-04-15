@extends('layouts.app')

@section('content')
    <!-- Main modal -->
    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Laporan Kejadian Bencana</h1>

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
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Simpan Laporan
                    </button>
                </div>
            </form>
        </div>

        {{-- Daftar Laporan --}}
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
                                        @elseif($report->status == 'pending')
                                            <span class="text-yellow-600 font-semibold">Pending</span>
                                        @else
                                            <span class="text-blue-600 font-semibold">Approved</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">{{ $report->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-4 py-2 border">
                                        <button data-modal-target="default-modal{{ $report->id }}"
                                            data-modal-toggle="default-modal{{ $report->id }}"
                                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            type="button">
                                            Detail
                                        </button>
                                    </td>
                                    <div id="default-modal{{ $report->id }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-50 md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                                <!-- Modal header -->
                                                <div
                                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        Detail
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="default-modal{{ $report->id }}">
                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="p-4 md:p-5 space-y-4">
                                                    <form method="POST"
                                                        action="{{ route('laporan.update', $report->id) }}"
                                                        class="space-y-4">
                                                        @csrf
                                                        @method('PUT')
                                                        <div>
                                                            <label for="location"
                                                                class="block text-gray-600 font-medium">Lokasi
                                                                Kejadian</label>
                                                            <input type="text" id="location" name="location"
                                                                value="{{ $report->location }}" required
                                                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">
                                                            @error('location')
                                                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                                            @enderror
                                                        </div>

                                                        <div>
                                                            <label for="description"
                                                                class="block text-gray-600 font-medium">Deskripsi
                                                                Kejadian</label>
                                                            <textarea id="description" name="description" rows="3" required
                                                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">{{ $report->description }}</textarea>
                                                            @error('description')
                                                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                                            @enderror
                                                        </div>

                                                        <div>
                                                            <label for="status"
                                                                class="block text-gray-600 font-medium">Status</label>
                                                            <select id="status" name="status" required
                                                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">
                                                                <option value="">Pilih Status</option>
                                                                <option value="rejected"
                                                                    {{ $report->status == 'rejected' ? 'selected' : '' }}>
                                                                    Merah (Rejected)</option>
                                                                <option value="pending"
                                                                    {{ $report->status == 'pending' ? 'selected' : '' }}>
                                                                    Kuning (Pending)</option>
                                                                <option value="approved"
                                                                    {{ $report->status == 'approved' ? 'selected' : '' }}>
                                                                    Biru (Approved)</option>
                                                            </select>
                                                            @error('status')
                                                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div
                                                    class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                    <button type="submit"
                                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                        update</button>
                                                    <button type="button" data-modal-target="popup-modal{{$report->id}}" data-modal-toggle="popup-modal{{$report->id}}"
                                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-red rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Delete</button>
                                                </div>
                                                </form>

                                                <div id="popup-modal{{$report->id}}" tabindex="-1"
                                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                                        <div
                                                            class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                                            <button type="button"
                                                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                                data-modal-hide="popup-modal{{$report->id}}">
                                                                <svg class="w-3 h-3" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                </svg>
                                                                <span class="sr-only">Close modal</span>
                                                            </button>
                                                            <div class="p-4 md:p-5 text-center">
                                                                <h3
                                                                    class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                                    Are you sure you want to delete this Data?</h3>
                                                                <form action="{{ route('laporan.destroy', $report->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                                    Yes, I'm sure
                                                                </button>
                                                                </form>
                                                                <button data-modal-hide="popup-modal{{$report->id}}" type="button"
                                                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                                                                    cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
