<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FloodMap;
use Illuminate\Support\Facades\Storage;

class FloodMapController extends Controller
{
    // Tampilkan semua data
    public function index()
    {
        $floodMaps = FloodMap::all();
        return view('admin.flood_maps.index', compact('floodMaps'));
    }

    // Tampilkan form tambah
    public function create()
    {
        return view('admin.flood_maps.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wilayah' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        // Simpan gambar jika ada
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('flood_maps', 'public');
        }

        FloodMap::create($validated);

        return redirect()->route('admin.flood-maps.index')->with('success', 'Data berhasil ditambahkan!');
    }

    // Tampilkan form edit
    public function edit(FloodMap $floodMap)
    {
        return view('admin.flood_maps.edit', compact('floodMap'));
    }

    // Update data
    public function update(Request $request, FloodMap $floodMap)
    {
        $validated = $request->validate([
            'wilayah' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            if ($floodMap->gambar) {
                Storage::disk('public')->delete($floodMap->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('flood_maps', 'public');
        }

        $floodMap->update($validated);

        return redirect()->route('admin.flood-maps.index')->with('success', 'Data berhasil diperbarui!');
    }

    // Hapus data
    public function destroy(FloodMap $floodMap)
    {
        if ($floodMap->gambar) {
            Storage::disk('public')->delete($floodMap->gambar);
        }

        $floodMap->delete();
        return redirect()->route('admin.flood-maps.index')->with('success', 'Data berhasil dihapus!');
    }
}
