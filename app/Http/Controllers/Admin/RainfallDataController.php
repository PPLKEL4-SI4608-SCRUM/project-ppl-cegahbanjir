<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\RainfallData;
use App\Models\WeatherStation;
use Illuminate\Http\Request;
use App\Services\OpenWeatherService;
use Carbon\Carbon;

class RainfallDataController extends Controller
{
    protected $weatherService;
    
    public function __construct(OpenWeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }
    
    /**
     * Klasifikasi curah hujan berdasarkan jumlah mm
     */
    private function classifyRainfall($amount)
    {
        if ($amount <= 5) {
            return 'rendah';
        } elseif ($amount <= 20) {
            return 'sedang';
        } elseif ($amount <= 50) {
            return 'tinggi';
        } else {
            return 'sangat_tinggi';
        }
    }
    
    public function index(Request $request)
    {
        $stations = WeatherStation::where('status', 'active')->orderBy('name')->get();
        
        $selectedStationId = $request->query('station_id');
        $rainfallData = [];
        $selectedStation = null;
        
        if ($selectedStationId) {
            $selectedStation = WeatherStation::findOrFail($selectedStationId);
            
            // Ambil semua data historis/manual untuk stasiun ini (30 hari terakhir + hari ini)
            $startDate = now()->subDays(30)->format('Y-m-d');
            $endDate = now()->format('Y-m-d');
            
            $historicalData = RainfallData::where('weather_station_id', $selectedStationId)
                ->whereBetween('date', [$startDate, $endDate])
                ->orderBy('date', 'desc')
                ->get();
            
            // Masukkan data historis/manual ke array
            foreach ($historicalData as $entry) {
                $dateKey = Carbon::parse($entry->date)->format('Y-m-d');
                $rainfallData[$dateKey] = [
                    'id' => $entry->id, // Tambahkan ID untuk edit/delete
                    'date' => $dateKey,
                    'rainfall_amount' => $entry->rainfall_amount,
                    'intensity' => $entry->intensity,
                    'category' => $entry->category,
                    'type' => 'historical',
                    'data_source' => $entry->data_source,
                    'is_saved' => true,
                    'can_edit' => in_array($entry->data_source, ['manual', 'sensor']), // Hanya manual dan sensor yang bisa diedit
                ];
            }
            
            // Jika belum ada data untuk hari ini, ambil dari API
            $today = now()->format('Y-m-d');
            if (!isset($rainfallData[$today])) {
                try {
                    $currentData = $this->weatherService->getCurrentRainfallData(
                        $selectedStation->latitude,
                        $selectedStation->longitude
                    );
                    
                    $rainfallData[$today] = [
                        'id' => null,
                        'date' => $today,
                        'rainfall_amount' => $currentData['rainfall_amount'],
                        'intensity' => $currentData['intensity'],
                        'category' => $this->classifyRainfall($currentData['rainfall_amount']),
                        'type' => 'current',
                        'data_source' => 'api',
                        'is_saved' => false,
                        'can_edit' => false, // Data API tidak bisa diedit
                    ];
                } catch (\Exception $e) {
                    // Jika API gagal, buat data kosong untuk hari ini
                    $rainfallData[$today] = [
                        'id' => null,
                        'date' => $today,
                        'rainfall_amount' => 0,
                        'intensity' => 0,
                        'category' => 'rendah',
                        'type' => 'current',
                        'data_source' => 'api',
                        'is_saved' => false,
                        'can_edit' => false,
                    ];
                }
            }
            
            // Urutkan data berdasarkan tanggal (terbaru dulu)
            krsort($rainfallData);
        }
        
        return view('admin.weather.rainfall.index', compact(
            'stations', 
            'rainfallData', 
            'selectedStationId', 
            'selectedStation'
        ));
    }
    
    public function updateCategory(Request $request)
    {
        $request->validate([
            'station_id' => 'required|exists:weather_stations,id',
            'categories' => 'required|array',
            'categories.*.date' => 'required|date',
            'categories.*.category' => 'required|string|in:rendah,sedang,tinggi,sangat_tinggi',
            'categories.*.rainfall_amount' => 'required|numeric|min:0',
            'categories.*.intensity' => 'required|numeric|min:0',
            'categories.*.data_source' => 'required|string',
        ]);
        
        $stationId = $request->input('station_id');
        $categories = $request->input('categories');
        $updatedCount = 0;
        
        foreach ($categories as $item) {
            // Update atau buat data baru untuk SEMUA jenis data source (manual, sensor, api)
            RainfallData::updateOrCreate(
                [
                    'weather_station_id' => $stationId,
                    'date' => $item['date'],
                ],
                [
                    'category' => $item['category'],
                    'rainfall_amount' => $item['rainfall_amount'],
                    'intensity' => $item['intensity'],
                    'data_source' => $item['data_source'],
                    'updated_by' => auth()->id(),
                ]
            );
            $updatedCount++;
        }
        
        return redirect()->route('admin.weather.rainfall.index', ['station_id' => $stationId])
            ->with('success', "Berhasil memperbarui klasifikasi {$updatedCount} data curah hujan");
    }
    
    public function create()
    {
        $stations = WeatherStation::where('status', 'active')->orderBy('name')->get();
        return view('admin.weather.rainfall.create', compact('stations'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'weather_station_id' => 'required|exists:weather_stations,id',
            'recorded_at' => 'required|date',
            'rainfall_amount' => 'required|numeric|min:0',
            'intensity' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|in:rendah,sedang,tinggi,sangat_tinggi',
            'data_source' => 'required|in:manual,sensor', // Hapus 'api' karena tidak boleh input manual
        ]);
        
        // Konversi recorded_at ke date
        $date = Carbon::parse($request->recorded_at)->format('Y-m-d');
        
        // Cek apakah sudah ada data untuk tanggal dan stasiun yang sama
        $existingData = RainfallData::where('weather_station_id', $request->weather_station_id)
            ->where('date', $date)
            ->first();
            
        if ($existingData) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['recorded_at' => 'Data untuk tanggal ini sudah ada. Silakan edit data yang sudah ada atau pilih tanggal lain.']);
        }
        
        // Hitung intensitas jika tidak diisi (asumsi data untuk 24 jam)
        $intensity = $request->intensity ?? ($request->rainfall_amount / 24);
        $category = $request->category ?? $this->classifyRainfall($request->rainfall_amount);
        
        RainfallData::create([
            'weather_station_id' => $request->weather_station_id,
            'date' => $date,
            'rainfall_amount' => $request->rainfall_amount,
            'intensity' => $intensity,
            'category' => $category,
            'data_source' => $request->data_source,
            'added_by' => auth()->id(),
        ]);
        
        return redirect()->route('admin.weather.rainfall.index', ['station_id' => $request->weather_station_id])
            ->with('success', 'Data curah hujan berhasil ditambahkan');
    }
    
    public function edit(RainfallData $rainfallData)
    {
        // Pastikan hanya data manual dan sensor yang bisa diedit
        if (!in_array($rainfallData->data_source, ['manual', 'sensor'])) {
            return redirect()->route('admin.weather.rainfall.index', ['station_id' => $rainfallData->weather_station_id])
                ->with('error', 'Hanya data manual dan sensor yang dapat diedit');
        }
        
        $stations = WeatherStation::where('status', 'active')->orderBy('name')->get();
        return view('admin.weather.rainfall.edit', compact('rainfallData', 'stations'));
    }
    
    public function update(Request $request, RainfallData $rainfallData)
    {
        // Pastikan hanya data manual dan sensor yang bisa diedit
        if (!in_array($rainfallData->data_source, ['manual', 'sensor'])) {
            return redirect()->route('admin.weather.rainfall.index', ['station_id' => $rainfallData->weather_station_id])
                ->with('error', 'Hanya data manual dan sensor yang dapat diedit');
        }
        
        $request->validate([
            'weather_station_id' => 'required|exists:weather_stations,id',
            'recorded_at' => 'required|date',
            'rainfall_amount' => 'required|numeric|min:0',
            'intensity' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|in:rendah,sedang,tinggi,sangat_tinggi',
            'data_source' => 'required|in:manual,sensor', // Hapus 'api'
        ]);
        
        $date = Carbon::parse($request->recorded_at)->format('Y-m-d');
        $intensity = $request->intensity ?? ($request->rainfall_amount / 24);
        $category = $request->category ?? $this->classifyRainfall($request->rainfall_amount);
        
        $rainfallData->update([
            'weather_station_id' => $request->weather_station_id,
            'date' => $date,
            'rainfall_amount' => $request->rainfall_amount,
            'intensity' => $intensity,
            'category' => $category,
            'data_source' => $request->data_source,
            'updated_by' => auth()->id(),
        ]);
        
        return redirect()->route('admin.weather.rainfall.index', ['station_id' => $request->weather_station_id])
            ->with('success', 'Data curah hujan berhasil diperbarui');
    }
    
    public function destroy(RainfallData $rainfallData)
    {
        // Pastikan hanya data manual dan sensor yang bisa dihapus
        if (!in_array($rainfallData->data_source, ['manual', 'sensor'])) {
            return redirect()->route('admin.weather.rainfall.index', ['station_id' => $rainfallData->weather_station_id])
                ->with('error', 'Hanya data manual dan sensor yang dapat dihapus');
        }
        
        $stationId = $rainfallData->weather_station_id;
        $rainfallData->delete();
        
        return redirect()->route('admin.weather.rainfall.index', ['station_id' => $stationId])
            ->with('success', 'Data curah hujan berhasil dihapus');
    }
}