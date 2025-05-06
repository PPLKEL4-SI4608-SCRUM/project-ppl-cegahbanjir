<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RainfallData;
use App\Models\WeatherStation;
use Illuminate\Http\Request;
use App\Services\OpenWeatherService;

class RainfallDataController extends Controller
{
    public function index()
    {
        $rainfallData = RainfallData::with(['weatherStation', 'addedBy'])
            ->orderByDesc('recorded_at')
            ->paginate(15);
            
        return view('admin.weather.rainfall.index', compact('rainfallData'));
    }

    public function create()
    {
        $stations = WeatherStation::where('status', 'active')->orderBy('name')->get();
        return view('admin.weather.rainfall.create', compact('stations'));
    }

    public function store(Request $request, OpenWeatherService $weatherService)
    {
        $validated = $request->validate([
            'weather_station_id' => 'required|exists:weather_stations,id',
            'recorded_at' => 'required|date',
            'rainfall_amount' => 'required|numeric|min:0',
            'intensity' => 'nullable|numeric|min:0',
            'data_source' => 'required|in:manual,api,sensor',
        ]);

        // Ambil stasiun cuaca
        $station = WeatherStation::findOrFail($validated['weather_station_id']);

        // Jika data dari API, ambil otomatis
        if ($validated['data_source'] === 'api') {
            $rainfall = $weatherService->getRainfall($station->latitude, $station->longitude);
            $validated['rainfall_amount'] = $rainfall ?? 0;
        }

        // Jika intensitas tidak diisi, hitung otomatis (mm / jam)
        if (empty($validated['intensity'])) {
            $validated['intensity'] = $validated['rainfall_amount'] / 1; // diasumsikan 1 jam
        }
        
        $validated['added_by'] = auth()->id();

        RainfallData::create($validated);

        return redirect()->route('admin.weather.rainfall.index')
            ->with('success', 'Data curah hujan berhasil ditambahkan');
    }

    public function edit(RainfallData $rainfall)
    {
        $stations = WeatherStation::where('status', 'active')->orderBy('name')->get();
        return view('admin.weather.rainfall.edit', compact('rainfall', 'stations'));
    }

    public function update(Request $request, RainfallData $rainfall)
    {
        $validated = $request->validate([
            'weather_station_id' => 'required|exists:weather_stations,id',
            'recorded_at' => 'required|date',
            'rainfall_amount' => 'required|numeric|min:0',
            'intensity' => 'nullable|numeric|min:0',
            'data_source' => 'required|in:manual,api,sensor',
        ]);

        $rainfall->update($validated);

        return redirect()->route('admin.weather.rainfall.index')
            ->with('success', 'Data curah hujan berhasil diperbarui');
    }

    public function destroy(RainfallData $rainfall)
    {
        $rainfall->delete();

        return redirect()->route('admin.weather.rainfall.index')
            ->with('success', 'Data curah hujan berhasil dihapus');
    }
}
