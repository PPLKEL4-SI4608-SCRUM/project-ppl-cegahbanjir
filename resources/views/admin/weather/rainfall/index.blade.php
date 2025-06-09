@extends('layouts.admin')
@section('title', 'Manajemen Data Curah Hujan')
@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manajemen Data Curah Hujan</h1>
        <a href="{{ route('admin.weather.rainfall.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#f97316] rounded hover:bg-[#ea580c]">
            <i class="fas fa-plus mr-2"></i> Tambah Data Manual
        </a>
    </div>
    <!-- Filter Stasiun -->
    <div class="bg-gray-50 p-4 rounded-lg mb-6">
        <form method="GET" action="{{ route('admin.weather.rainfall.index') }}" class="flex items-end gap-4">
            <div class="flex-1">
                <label for="station_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Stasiun Cuaca</label>
                <select name="station_id" id="station_id" class="w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black" onchange="this.form.submit()">
                    <option value="">-- Pilih Stasiun --</option>
                    @foreach($stations as $station)
                        <option value="{{ $station->id }}" {{ $selectedStationId == $station->id ? 'selected' : '' }}>
                            {{ $station->name }} ({{ $station->location }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    <i class="fas fa-search mr-2"></i> Tampilkan Data
                </button>
            </div>
        </form>
    </div>
    @if($selectedStation && !empty($rainfallData))
        <!-- Info Stasiun -->
        <div class="bg-blue-50 p-4 rounded-lg mb-6">
            <h3 class="font-semibold text-blue-800 mb-2">{{ $selectedStation->name }}</h3>
            <p class="text-blue-600 text-sm">
                Lokasi: {{ $selectedStation->location }} | 
                Koordinat: {{ $selectedStation->latitude }}, {{ $selectedStation->longitude }}
            </p>
        </div>
        <!-- Form Update Kategori -->
        <form action="{{ route('admin.weather.rainfall.update-category') }}" method="POST" id="categoryForm">
            @csrf
            <input type="hidden" name="station_id" value="{{ $selectedStationId }}">
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Data Curah Hujan</h3>
                    <div class="text-sm text-gray-600">
                        <span class="inline-block w-3 h-3 bg-blue-500 rounded-full mr-2"></span> Data Historis
                        <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-2 ml-4"></span> Data API
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                                <th class="px-4 py-3 text-left font-semibold">Curah Hujan (mm)</th>
                                <th class="px-4 py-3 text-left font-semibold">Intensitas (mm/jam)</th>
                                <th class="px-4 py-3 text-left font-semibold">Sumber Data</th>
                                <th class="px-4 py-3 text-left font-semibold">Klasifikasi</th>
                                <th class="px-4 py-3 text-left font-semibold">Status</th>
                                <th class="px-4 py-3 text-left font-semibold">Tipe Data</th>
                                <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($rainfallData as $date => $data)
                                <tr class="{{ $data['type'] == 'historical' ? 'bg-blue-50' : 'bg-green-50' }}">
                                    <td class="px-4 py-3 font-medium">
                                        {{ \Carbon\Carbon::parse($data['date'])->format('d M Y') }}
                                        @if(\Carbon\Carbon::parse($data['date'])->isToday())
                                            <span class="text-xs bg-yellow-200 text-yellow-800 px-2 py-1 rounded ml-2">Hari Ini</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ number_format($data['rainfall_amount'], 1) }} mm
                                        <input type="hidden" name="categories[{{ $loop->index }}][date]" value="{{ $data['date'] }}">
                                        <input type="hidden" name="categories[{{ $loop->index }}][rainfall_amount]" value="{{ $data['rainfall_amount'] }}">
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ number_format($data['intensity'], 2) }} mm/jam
                                        <input type="hidden" name="categories[{{ $loop->index }}][intensity]" value="{{ $data['intensity'] }}">
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded
                                            @if($data['data_source'] == 'manual') 
                                                text-blue-800 bg-blue-200
                                            @elseif($data['data_source'] == 'sensor') 
                                                text-purple-800 bg-purple-200
                                            @elseif($data['data_source'] == 'api') 
                                                text-green-800 bg-green-200
                                            @else 
                                                text-gray-800 bg-gray-200
                                            @endif">
                                            {{ ucfirst($data['data_source']) }}
                                        </span>
                                        <input type="hidden" name="categories[{{ $loop->index }}][data_source]" value="{{ $data['data_source'] }}">
                                    </td>
                                    <td class="px-4 py-3">
                                        <select name="categories[{{ $loop->index }}][category]" 
                                                class="text-xs rounded border-gray-300 focus:ring-blue-500 focus:border-blue-500 category-select"
                                                data-original="{{ $data['category'] }}">
                                            <option value="rendah" {{ $data['category'] == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                            <option value="sedang" {{ $data['category'] == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                            <option value="tinggi" {{ $data['category'] == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                            <option value="sangat_tinggi" {{ $data['category'] == 'sangat_tinggi' ? 'selected' : '' }}>Sangat Tinggi</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($data['is_saved'])
                                            <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-green-600 rounded">Tersimpan</span>
                                        @else
                                            <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-gray-500 rounded">Otomatis</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($data['type'] == 'historical')
                                            <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-blue-600 rounded">Historis</span>
                                        @else
                                            <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-green-600 rounded">API</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if(isset($data['id']) && $data['id'])
                                            <div class="flex items-center gap-2">
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('admin.weather.rainfall.edit', $data['id']) }}" 
                                                   class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700"
                                                   title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <!-- PERBAIKAN: Form Hapus dengan ID unik dan event handler yang tepat -->
                                                <button type="button" 
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700 delete-btn"
                                                        title="Hapus Data"
                                                        data-id="{{ $data['id'] }}"
                                                        data-station="{{ $selectedStationId }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400">Data belum tersimpan</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        <strong>Keterangan Klasifikasi:</strong><br>
                        <span class="text-green-600">Rendah:</span> 0-5mm | 
                        <span class="text-yellow-600">Sedang:</span> 5-20mm | 
                        <span class="text-orange-600">Tinggi:</span> 20-50mm | 
                        <span class="text-red-600">Sangat Tinggi:</span> >50mm
                        <br><br>
                        <strong>Sumber Data:</strong><br>
                        <span class="inline-block w-3 h-3 bg-blue-200 rounded mr-1"></span> Manual | 
                        <span class="inline-block w-3 h-3 bg-purple-200 rounded mr-1 ml-2"></span> Sensor | 
                        <span class="inline-block w-3 h-3 bg-green-200 rounded mr-1 ml-2"></span> API
                        <br><br>
                        <strong>Catatan:</strong> Semua data yang tersimpan dapat diedit dan dihapus.
                    </div>
                    <div class="flex gap-2">
                        <button type="button" onclick="resetCategories()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            <i class="fas fa-undo mr-2"></i> Reset
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#f97316] text-white rounded hover:bg-[#ea580c]" id="saveButton" disabled>
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @elseif($selectedStation && empty($rainfallData))
        <div class="text-center py-8">
            <i class="fas fa-cloud-rain text-gray-400 text-4xl mb-4"></i>
            <p class="text-gray-600">Tidak ada data curah hujan untuk stasiun ini.</p>
        </div>
    @else
        <div class="text-center py-8">
            <i class="fas fa-map-marker-alt text-gray-400 text-4xl mb-4"></i>
            <p class="text-gray-600">Silakan pilih stasiun cuaca untuk melihat data curah hujan.</p>
        </div>
    @endif
</div>

<!-- PERBAIKAN: Form delete terpisah untuk menghindari konflik -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50" id="successAlert">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-lg z-50" id="errorAlert">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
    </div>
@endif
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelects = document.querySelectorAll('.category-select');
    const saveButton = document.getElementById('saveButton');
    
    // PERBAIKAN: Event handler untuk tombol delete
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const id = this.getAttribute('data-id');
            const stationId = this.getAttribute('data-station');
            
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `{{ url('admin/weather/rainfall') }}/${id}`;
                deleteForm.submit();
            }
        });
    });
    
    function checkForChanges() {
        let hasChanges = false;
        // Cek perubahan kategori manual
        categorySelects.forEach(select => {
            const original = select.getAttribute('data-original');
            const current = select.value;
            if (original !== current) {
                hasChanges = true;
            }
        });
        // Tambahan: cek apakah ada data yang belum tersimpan
        const anyNotSaved = Array.from(document.querySelectorAll('span.bg-gray-500')).length > 0;
        // Jika ada perubahan kategori ATAU ada data otomatis yang belum tersimpan
        saveButton.disabled = !(hasChanges || anyNotSaved);
    }
    
    // Listener perubahan dropdown
    categorySelects.forEach(select => {
        select.addEventListener('change', checkForChanges);
    });
    
    // Jalankan saat awal load
    checkForChanges();
    
    window.resetCategories = function () {
        categorySelects.forEach(select => {
            const original = select.getAttribute('data-original');
            select.value = original;
        });
        checkForChanges(); // Panggil ulang pengecekan
    };
    
    // Auto hide alerts
    setTimeout(function() {
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 5000);
});
</script>
@endpush