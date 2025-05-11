<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FloodMap;
use Illuminate\Http\Request;

class FloodMapController extends Controller
{
    public function index()
    {
        $floodMaps = FloodMap::all();
        return view('admin.flood_maps.index', compact('floodMaps'));
    }

    public function create()
    {
        return view('admin.flood_maps.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'wilayah' => 'required|string|max:255',
            'tingkat_risiko' => 'required|string',
            'polygon_coordinates' => 'required|string'
        ]);

        FloodMap::create([
            'wilayah' => $request->wilayah,
            'tingkat_risiko' => $request->tingkat_risiko,
            'polygon_coordinates' => $request->polygon_coordinates,
        ]);

        return redirect()->route('admin.flood-maps.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(FloodMap $floodMap)
    {
        return view('admin.flood_maps.edit', compact('floodMap'));
    }

    public function update(Request $request, FloodMap $floodMap)
    {
        $request->validate([
            'wilayah' => 'required|string|max:255',
            'tingkat_risiko' => 'required|string',
            'polygon_coordinates' => 'required|string'
        ]);

        $floodMap->update([
            'wilayah' => $request->wilayah,
            'tingkat_risiko' => $request->tingkat_risiko,
            'polygon_coordinates' => $request->polygon_coordinates,
        ]);

        return redirect()->route('admin.flood-maps.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(FloodMap $floodMap)
    {
        $floodMap->delete();
        return redirect()->route('admin.flood-maps.index')->with('success', 'Data berhasil dihapus!');
    }
}
