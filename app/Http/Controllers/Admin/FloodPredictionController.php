<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FloodPrediction;
use App\Models\WeatherStation;
use Illuminate\Http\Request;

class FloodPredictionController extends Controller
{
    public function index()
    {
        $predictions = FloodPrediction::with(['weatherStation', 'createdBy'])
            ->orderByDesc('prediction_date')
            ->paginate(15);
            
        return view('admin.weather.predictions.index', compact('predictions'));
    }

    public function create()
    {
        $stations = WeatherStation::where('status', 'active')->orderBy('name')->get();
        $riskLevels = ['rendah', 'sedang', 'tinggi', 'sangat tinggi'];
        
        return view('admin.weather.predictions.create', compact('stations', 'riskLevels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'weather_station_id' => 'required|exists:weather_stations,id',
            'prediction_date' => 'required|date',
            'risk_level' => 'required|in:rendah,sedang,tinggi,sangat tinggi',
            'predicted_rainfall' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();

        FloodPrediction::create($validated);

        return redirect()->route('admin.weather.predictions.index')
            ->with('success', 'Prediksi banjir berhasil ditambahkan');
    }

    public function edit(FloodPrediction $prediction)
    {
        $stations = WeatherStation::where('status', 'active')->orderBy('name')->get();
        $riskLevels = ['rendah', 'sedang', 'tinggi', 'sangat tinggi'];
        
        return view('admin.weather.predictions.edit', compact('prediction', 'stations', 'riskLevels'));
    }

    public function update(Request $request, FloodPrediction $prediction)
    {
        $validated = $request->validate([
            'weather_station_id' => 'required|exists:weather_stations,id',
            'prediction_date' => 'required|date',
            'risk_level' => 'required|in:rendah,sedang,tinggi,sangat tinggi',
            'predicted_rainfall' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['updated_by'] = auth()->id();

        $prediction->update($validated);

        return redirect()->route('admin.weather.predictions.index')
            ->with('success', 'Prediksi banjir berhasil diperbarui');
    }

    public function destroy(FloodPrediction $prediction)
    {
        $prediction->delete();

        return redirect()->route('admin.weather.predictions.index')
            ->with('success', 'Prediksi banjir berhasil dihapus');
    }
}
