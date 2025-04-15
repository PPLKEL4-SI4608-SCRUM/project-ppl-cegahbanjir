<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeatherStation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WeatherStationController extends Controller
{
    public function index()
    {
        $stations = WeatherStation::orderBy('name')->paginate(10);
        return view('admin.weather.stations.index', compact('stations'));
    }

    public function create()
    {
        return view('admin.weather.stations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'status' => 'required|in:active,maintenance,inactive',
        ]);

        WeatherStation::create($validated);

        return redirect()->route('admin.weather.stations.index')
            ->with('success', 'Stasiun cuaca berhasil ditambahkan');
    }

    public function edit(WeatherStation $station)
    {
        return view('admin.weather.stations.edit', compact('station'));
    }

    public function update(Request $request, WeatherStation $station)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'status' => 'required|in:active,maintenance,inactive',
        ]);

        $station->update($validated);

        return redirect()->route('admin.weather.stations.index')
            ->with('success', 'Stasiun cuaca berhasil diperbarui');
    }

    public function destroy(WeatherStation $station)
    {
        $station->delete();

        return redirect()->route('admin.weather.stations.index')
            ->with('success', 'Stasiun cuaca berhasil dihapus');
    }
}
