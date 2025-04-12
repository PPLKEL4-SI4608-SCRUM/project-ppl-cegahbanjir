<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FloodWarningParameter;
use App\Models\WeatherStation;
use Illuminate\Http\Request;

class FloodWarningParameterController extends Controller
{
    public function index()
    {
        $parameters = FloodWarningParameter::with(['weatherStation', 'updatedBy'])
            ->paginate(15);
            
        return view('admin.weather.parameters.index', compact('parameters'));
    }

    public function create()
    {
        $stations = WeatherStation::where('status', 'active')->orderBy('name')->get();
        
        // Check if any stations don't have parameters yet
        $stationsWithoutParams = $stations->filter(function($station) {
            return !$station->warningParameters()->exists();
        });
        
        if ($stationsWithoutParams->isEmpty()) {
            return redirect()->route('admin.weather.parameters.index')
                ->with('warning', 'Semua stasiun cuaca sudah memiliki parameter peringatan');
        }
        
        return view('admin.weather.parameters.create', compact('stationsWithoutParams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'weather_station_id' => [
                'required',
                'exists:weather_stations,id',
                // Make sure there's no existing parameter for this station
                function ($attribute, $value, $fail) {
                    if (FloodWarningParameter::where('weather_station_id', $value)->exists()) {
                        $fail('Stasiun cuaca ini sudah memiliki parameter peringatan');
                    }
                },
            ],
            'threshold_low' => 'required|numeric|min:0',
            'threshold_medium' => 'required|numeric|gt:threshold_low',
            'threshold_high' => 'required|numeric|gt:threshold_medium',
            'threshold_very_high' => 'required|numeric|gt:threshold_high',
            'consecutive_days' => 'required|integer|min:1',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['updated_by'] = auth()->id();
        $validated['is_active'] = $request->has('is_active');

        FloodWarningParameter::create($validated);

        return redirect()->route('admin.weather.parameters.index')
            ->with('success', 'Parameter peringatan banjir berhasil ditambahkan');
    }

    public function edit(FloodWarningParameter $parameter)
    {
        $station = $parameter->weatherStation;
        
        return view('admin.weather.parameters.edit', compact('parameter', 'station'));
    }

    public function update(Request $request, FloodWarningParameter $parameter)
    {
        $validated = $request->validate([
            'threshold_low' => 'required|numeric|min:0',
            'threshold_medium' => 'required|numeric|gt:threshold_low',
            'threshold_high' => 'required|numeric|gt:threshold_medium',
            'threshold_very_high' => 'required|numeric|gt:threshold_high',
            'consecutive_days' => 'required|integer|min:1',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['updated_by'] = auth()->id();
        $validated['is_active'] = $request->has('is_active');

        $parameter->update($validated);

        return redirect()->route('admin.weather.parameters.index')
            ->with('success', 'Parameter peringatan banjir berhasil diperbarui');
    }
}