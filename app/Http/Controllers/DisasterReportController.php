<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DisasterReport; // Pastikan model ini ada
use Illuminate\Support\Facades\Auth;

class DisasterReportController extends Controller
{
    public function index()
    {
        $reports = DisasterReport::all();
        return view('disaster.index', compact('reports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'description' => 'required|string|max:255',
            'location' => 'required|string',
        ]);

        $input = $request->only('status', 'description', 'location');

        $input['user_id'] = Auth::user()->id;


        $create = DisasterReport::create($input);

        if ($create) {
            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
        }

        return redirect()->route('laporan.index')->with('gagal', 'Data gagal ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $laporan = DisasterReport::findOrFail($id);

        $request->validate([
            'status' => 'required',
            'description' => 'required|string|max:255',
            'location' => 'required|string',
        ]);

        $input = $request->only('status', 'description', 'location');

        $update = $laporan->update($input);

        if ($update) {
            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
        }

        return redirect()->route('laporan.index')->with('gagal', 'Data gagal ditambahkan.');
    }

    public function destroy($id)
    {
        $laporan = DisasterReport::findOrFail($id);
        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
