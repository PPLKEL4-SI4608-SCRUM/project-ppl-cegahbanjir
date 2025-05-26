@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto px-6 mt-10">
        <div class="bg-white bg-opacity-80 backdrop-blur-md rounded-2xl shadow-lg p-6 text-gray-800"> {{-- Main container matches admin dashboard style --}}

            {{-- Page Header --}}
            <div class="flex justify-between items-center mb-6 border-b-2 border-gray-200 pb-4"> {{-- Added subtle border for separation --}}
                <h2 class="text-3xl font-bold text-gray-800">Riwayat Banjir</h2> {{-- Increased title size slightly --}}
                <a href="{{ route('admin.flood_history.create') }}"
                    class="flex items-center bg-[#FFA404] text-white px-5 py-2.5 rounded-lg hover:bg-[#e69400] transition shadow-md"> {{-- Orange button --}}
                    <i class="fas fa-plus mr-2"></i> Tambah Data Baru
                </a>
            </div>
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4 shadow">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4 shadow">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4 shadow">
                    {{ session('warning') }}
                </div>
            @endif

            {{-- Flood History Cards --}}
            @forelse ($floods as $flood)
                <div class="bg-white shadow-md rounded-xl overflow-hidden mb-5 p-5 flex flex-col md:flex-row items-stretch gap-5 border-l-4 border-[#FFA404] hover:shadow-lg transition transform hover:-translate-y-1"> {{-- Orange left border, subtle lift on hover --}}
                    {{-- Gambar --}}
                    <div class="flex-shrink-0 w-full md:w-56 h-36 rounded-lg overflow-hidden shadow-inner"> {{-- Slightly larger image container --}}
                        @if ($flood->images && Storage::disk('public')->exists($flood->images))
                            <img src="{{ asset('storage/' . $flood->images) }}" alt="Gambar Banjir di {{ $flood->location }}"
                                class="w-full h-full object-cover">
                        @else
                            {{-- Placeholder image for missing images --}}
                            <img src="{{ asset('images/placeholder-flood.jpg') }}" alt="Tidak ada gambar"
                                class="w-full h-full object-cover bg-gray-200 flex items-center justify-center text-gray-500">
                        @endif
                    </div>

                    {{-- Konten --}}
                    <div class="flex-1 flex flex-col justify-between">
                        {{-- Lokasi dan Tanggal --}}
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-2">
                            <h3 class="text-xl md:text-2xl font-bold text-gray-900">{{ $flood->location }}</h3> {{-- Stronger text --}}
                            <span class="text-sm text-gray-500 font-medium">{{ \Carbon\Carbon::parse($flood->date)->format('d F Y') }}</span> {{-- Full month name --}}
                        </div>

                        {{-- Deskripsi --}}
                        <p class="text-base text-gray-700 leading-relaxed mb-3">
                            {{ Str::limit($flood->impact, 150) }} {{-- Use Str::limit for shorter preview --}}
                        </p>

                        {{-- Aksi Buttons --}}
                        <div class="flex gap-3 mt-auto pt-3 border-t border-gray-100"> {{-- Actions always at bottom, separated by a thin border --}}
                            <a href="{{ route('admin.flood_history.edit', $flood->id) }}"
                                class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 flex items-center transition shadow-sm text-sm font-semibold"> {{-- Adjusted yellow for Edit --}}
                                <i class="fas fa-pen mr-2"></i> Edit
                            </a>
                            
                            {{-- Delete Button: Now triggers the single generic modal --}}
                            <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 flex items-center transition shadow-sm text-sm font-semibold delete-flood-btn"
                                data-id="{{ $flood->id }}" data-modal-target="delete-modal" data-modal-toggle="delete-modal">
                                <i class="fas fa-trash mr-2"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Message when no flood history data is available --}}
                <div class="bg-white shadow-md rounded-xl p-5 text-center text-gray-600">
                    Belum ada riwayat banjir yang tersedia.
                </div>
            @endforelse

            {{-- Pagination Links --}}
            <div class="mt-6 flex justify-center"> {{-- Center pagination links --}}
                {{ $floods->links() }}
            </div>
        </div>
    </div>

    {{-- DELETE CONFIRMATION MODAL (SINGLE INSTANCE) --}}
    {{-- This modal is hidden by default and controlled by Flowbite JS --}}
    <div id="delete-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[9999] justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900 bg-opacity-50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                {{-- Modal Close Button --}}
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                {{-- Modal Content --}}
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah Anda yakin ingin menghapus data riwayat banjir ini?</h3>
                    {{-- Form for actual deletion --}}
                    <form id="deleteFloodForm" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Ya, saya yakin
                        </button>
                    </form>
                    {{-- Cancel Button for Modal --}}
                    <button data-modal-hide="delete-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Tidak, batal</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Pastikan Flowbite JS dimuat di layout Anda atau di sini --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-flood-btn');
            const deleteForm = document.getElementById('deleteFloodForm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const floodId = this.dataset.id;
                    // Update the form action dynamically
                    deleteForm.action = `/admin/flood_history/${floodId}`; // Pastikan rute ini sesuai dengan route Anda
                });
            });
        });
    </script>
@endsection