<?php

namespace App\Http\Controllers\Admin;

use App\Models\FloodHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FloodHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $floods = FloodHistory::latest()->paginate(5);

        // This line is now correct based on your file structure (resources/views/admin/flood_history/index.blade.php)
        return view('admin.flood_history.index', compact('floods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.flood_history.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'impact' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('images')) {
            $imagePath = $request->file('images')->store('flood_images', 'public');
            $data['images'] = $imagePath;
        }

        FloodHistory::create($data);

        // This redirect route name is correct (plural, hyphenated)
        return redirect()->route('admin.flood_history.index')->with('success', 'Data Berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // This method is correctly left blank as it's not implemented for a specific view here.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $flood = FloodHistory::findOrFail($id);

        return view('admin.flood_history.edit', compact('flood'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'impact' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $flood = FloodHistory::findOrFail($id);
        $data = $request->only('impact', 'date', 'location');

        if ($request->hasFile('images')) {
            if ($flood->images && Storage::disk('public')->exists($flood->images)) {
                Storage::disk('public')->delete($flood->images);
            }

            $imagePath = $request->file('images')->store('flood_images', 'public');
            $data['images'] = $imagePath;
        }

        $flood->update($data);

        // This redirect route name is correct (plural, hyphenated)
        return redirect()->route('admin.flood_history.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $flood = FloodHistory::findOrFail($id);

        if ($flood->images && Storage::disk('public')->exists($flood->images)) {
            Storage::disk('public')->delete($flood->images);
        }

        $flood->delete();

        // This redirect route name is correct (plural, hyphenated)
        return redirect()->route('admin.flood_history.index')->with('success', 'Data berhasil dihapus.');
    }
}