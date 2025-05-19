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
            'description' => 'required|string|max:255',
            'location' => 'required|string',
        ]);

        $input = $request->only('status', 'description', 'location');

        $files = $request->file('disaster_image');
        $ext = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
        $file_ext = $files->getClientOriginalExtension();

        if (in_array($file_ext, $ext)) {
            $name = \Illuminate\Support\Str::random(7) . "_" . Auth::user()->id . "_" . $files->getClientOriginalName();
            $input['disaster_image'] = $name;
            $request->disaster_image->move(public_path() . "/disaster_images", $name);
        } else {
            return redirect()->route('laporan.index')->with('gagal', 'Format tidak sesuai');
        }

        $input['user_id'] = Auth::user()->id;
        $input['status'] = 'pending';

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
            'description' => 'required|string|max:255',
            'location' => 'required|string',
        ]);

        $input = $request->only('description', 'location');

        if ($request->file('disaster_image')) {
            $files = $request->file('disaster_image');
            $ext = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
            $file_ext = $files->getClientOriginalExtension();

            if (in_array($file_ext, $ext)) {
                $name = \Illuminate\Support\Str::random(7) . "_" . Auth::user()->id . "_" . $files->getClientOriginalName();
                $input['disaster_image'] = $name;
                $request->disaster_image->move(public_path() . "/disaster_images", $name);
            } else {
                return redirect()->route('laporan.index')->with('gagal', 'Format tidak sesuai');
            }
        }

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
