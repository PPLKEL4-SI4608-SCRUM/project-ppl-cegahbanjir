@extends('layouts.admin')
@section('title', 'Edit Data Curah Hujan')

@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Data Curah Hujan</h1>
        <a href="{{ route('admin.weather.rainfall.index', ['station_id' => $rainfallData->weather_station_id]) }}" 
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <!-- Info Data yang akan diedit -->
    <div class="bg-blue-50 p-4 rounded-lg mb-6">
        <h3 class="font-semibold text-blue-800 mb-2">Data yang akan diedit</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-blue-700">
            <div>
                <strong>Stasiun:</strong> {{ $rainfallData->weatherStation->name }}
            </div>
            <div>
                <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($rainfallData->date)->format('d M Y') }}
            </div>
            <div>
                <strong>Sumber Data:</strong> 
                <span class="inline-block px-2 py-1 text-xs font-semibold rounded
                    @if($rainfallData->data_source == 'manual') 
                        text-blue-800 bg-blue-200
                    @elseif($rainfallData->data_source == 'sensor') 
                        text-purple-800 bg-purple-200
                    @else 
                        text-gray-800 bg-gray-200
                    @endif">
                    {{ ucfirst($rainfallData->data_source) }}
                </span>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('admin.weather.rainfall.update', $rainfallData) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="weather_station_id" class="block text-sm font-medium text-gray-700">Stasiun Cuaca <span class="text-red-500">*</span></label>
                <select id="weather_station_id" name="weather_station_id" required
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('weather_station_id') border-red-500 @enderror">
                    <option value="">Pilih Stasiun Cuaca</option>
                    @foreach($stations as $station)
                        <option value="{{ $station->id }}" {{ old('weather_station_id', $rainfallData->weather_station_id) == $station->id ? 'selected' : '' }}>
                            {{ $station->name }} ({{ $station->location }})
                        </option>
                    @endforeach
                </select>
                @error('weather_station_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="recorded_at" class="block text-sm font-medium text-gray-700">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" id="recorded_at" name="recorded_at" required
                        value="{{ old('recorded_at', $rainfallData->date) }}"
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('recorded_at') border-red-500 @enderror">
                    @error('recorded_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Format: YYYY-MM-DD</p>
                </div>
                <div>
                    <label for="data_source" class="block text-sm font-medium text-gray-700">Sumber Data <span class="text-red-500">*</span></label>
                    <select id="data_source" name="data_source" required
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('data_source') border-red-500 @enderror">
                        <option value="manual" {{ old('data_source', $rainfallData->data_source) == 'manual' ? 'selected' : '' }}>Manual</option>
                        <option value="sensor" {{ old('data_source', $rainfallData->data_source) == 'sensor' ? 'selected' : '' }}>Sensor</option>
                    </select>
                    @error('data_source')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Hanya data manual dan sensor yang dapat diedit</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="rainfall_amount" class="block text-sm font-medium text-gray-700">Curah Hujan (mm) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.1" min="0" id="rainfall_amount" name="rainfall_amount" required
                        value="{{ old('rainfall_amount', $rainfallData->rainfall_amount) }}"
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('rainfall_amount') border-red-500 @enderror"
                        onchange="calculateCategory()">
                    @error('rainfall_amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="intensity" class="block text-sm font-medium text-gray-700">Intensitas (mm/jam)</label>
                    <input type="number" step="0.01" min="0" id="intensity" name="intensity"
                        value="{{ old('intensity', $rainfallData->intensity) }}"
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('intensity') border-red-500 @enderror">
                    @error('intensity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Opsional. Akan dihitung otomatis jika tidak diisi (curah hujan ÷ 24 jam).</p>
                </div>
            </div>

            <div class="mb-6">
                <label for="category" class="block text-sm font-medium text-gray-700">Klasifikasi</label>
                <select id="category" name="category"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 @error('category') border-red-500 @enderror">
                    <option value="rendah" {{ old('category', $rainfallData->category) == 'rendah' ? 'selected' : '' }}>Rendah (0-5mm)</option>
                    <option value="sedang" {{ old('category', $rainfallData->category) == 'sedang' ? 'selected' : '' }}>Sedang (5-20mm)</option>
                    <option value="tinggi" {{ old('category', $rainfallData->category) == 'tinggi' ? 'selected' : '' }}>Tinggi (20-50mm)</option>
                    <option value="sangat_tinggi" {{ old('category', $rainfallData->category) == 'sangat_tinggi' ? 'selected' : '' }}>Sangat Tinggi (>50mm)</option>
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Akan dihitung otomatis berdasarkan jumlah curah hujan jika tidak dipilih.</p>
            </div>

            <!-- Informasi Klasifikasi -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h4 class="font-medium text-gray-800 mb-2">Keterangan Klasifikasi Curah Hujan:</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 text-sm">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                        <span><strong>Rendah:</strong> 0-5mm</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                        <span><strong>Sedang:</strong> 5-20mm</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>
                        <span><strong>Tinggi:</strong> 20-50mm</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                        <span><strong>Sangat Tinggi:</strong> >50mm</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.weather.rainfall.index', ['station_id' => $rainfallData->weather_station_id]) }}" 
                   class="px-4 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-200">
                    Batal
                </a>
                <button type="reset" class="px-4 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-200">
                    <i class="fas fa-undo mr-2"></i>Reset
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#f97316] rounded hover:bg-[#ea580c]">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

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
    // Auto hide alerts
    setTimeout(function() {
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 5000);
});

// Fungsi untuk menghitung kategori otomatis berdasarkan curah hujan
function calculateCategory() {
    const rainfallAmount = parseFloat(document.getElementById('rainfall_amount').value) || 0;
    const categorySelect = document.getElementById('category');
    
    let category = 'rendah';
    if (rainfallAmount > 50) {
        category = 'sangat_tinggi';
    } else if (rainfallAmount > 20) {
        category = 'tinggi';
    } else if (rainfallAmount > 5) {
        category = 'sedang';
    }
    
    categorySelect.value = category;
    
    // Update intensitas jika belum diisi
    const intensityInput = document.getElementById('intensity');
    if (!intensityInput.value || intensityInput.value == 0) {
        intensityInput.value = (rainfallAmount / 24).toFixed(2);
    }
}

// Auto calculate ketika curah hujan berubah
document.getElementById('rainfall_amount').addEventListener('input', calculateCategory);
</script>
@endpush