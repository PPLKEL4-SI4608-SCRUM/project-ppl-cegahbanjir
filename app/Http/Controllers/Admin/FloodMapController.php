<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WeatherStation;
use App\Models\FloodMap;
use App\Models\RainfallData;

class FloodMapController extends Controller
{
    public function index()
    {
        $floodMaps = FloodMap::all();
        return view('admin.flood_maps.index', compact('floodMaps'));
    }

    public function create(Request $request)
    {
        $stations = WeatherStation::all();
        $selectedStation = $request->input('station_id');

        $rainfalls = collect();
        if ($selectedStation) {
            $rainfalls = RainfallData::where('weather_station_id', $selectedStation)
                ->whereDate('date', now()->toDateString())
                ->orderByDesc('created_at')
                ->get();
        }

        return view('admin.flood_maps.create', compact('stations', 'selectedStation', 'rainfalls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'wilayah' => 'required|string|max:255',
            'polygons' => 'required|string'
        ]);

        FloodMap::create([
            'wilayah' => $request->wilayah,
            'polygons' => $request->polygons
        ]);

        return redirect()->route('admin.flood-maps.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(FloodMap $floodMap, Request $request)
    {
        $stations = WeatherStation::all();
        $selectedStation = $request->input('station_id');

        $rainfalls = collect();
        if ($selectedStation) {
            $rainfalls = RainfallData::where('weather_station_id', $selectedStation)
                ->whereDate('date', now()->toDateString())
                ->orderByDesc('created_at')
                ->get();
        }

        return view('admin.flood_maps.edit', compact('floodMap', 'stations', 'selectedStation', 'rainfalls'));
    }

    public function update(Request $request, FloodMap $floodMap)
    {
        $request->validate([
            'wilayah' => 'required|string|max:255',
            'polygons' => 'required|string'
        ]);

        $floodMap->update([
            'wilayah' => $request->wilayah,
            'polygons' => $request->polygons
        ]);

        return redirect()->route('admin.flood-maps.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(FloodMap $floodMap)
    {
        $floodMap->delete();
        return redirect()->route('admin.flood-maps.index')->with('success', 'Data berhasil dihapus!');
    }
}
