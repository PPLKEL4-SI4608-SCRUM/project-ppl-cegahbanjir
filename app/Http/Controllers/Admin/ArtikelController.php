<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Solutions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Str;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::with('solutions')->latest()->get();
        return view('admin.artikels.index', compact('artikels'));
    }

    public function create()
    {
        return view('admin.artikels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'solution_titles' => 'required|array',
            'solution_descriptions' => 'required|array',
            'solution_icons' => 'nullable|array',
            'solution_titles.*' => 'required|string|max:255',
            'solution_descriptions.*' => 'required|string',
            'solution_icons.*' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        // Upload main image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = Str::random(7) . "_" . Auth::id() . "_" . $image->getClientOriginalName();
            $image->move(public_path('artikel_images'), $name);
            $imagePath = $name;
        } else {
            $imagePath = null;
        }

        // Upload main icon
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $name = Str::random(7) . "_" . Auth::id() . "_" . $icon->getClientOriginalName();
            $icon->move(public_path('artikel_icons'), $name);
            $iconPath = $name;
        } else {
            $iconPath = null;
        }

        // Save Artikel
        $artikel = Artikel::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'icon_path' => $iconPath,
        ]);

        $titles = $request->input('solution_titles');
        $descriptions = $request->input('solution_descriptions');
        $icons = $request->file('solution_icons', []);

        // Save each Solution
        for ($i = 0; $i < count($titles); $i++) {
            $iconFile = $icons[$i] ?? null;
            $iconSolutionPath = null;

            if ($iconFile) {
                $name = Str::random(7) . "_" . Auth::id() . "_" . $iconFile->getClientOriginalName();
                $iconFile->move(public_path('solution_icons'), $name);
                $iconSolutionPath = $name;
            }

            Solutions::create([
                'artikel_id' => $artikel->id,
                'title' => $titles[$i],
                'description' => $descriptions[$i],
                'icon_path' => $iconSolutionPath,
            ]);
        }

        return redirect()->route('admin.artikels.index')->with('success', 'Artikel berhasil dibuat.');
    }


    public function edit(Artikel $artikel)
    {
        $artikel->load('solutions');
        // return response($artikel->solutions);
        return view('admin.artikels.edit', compact('artikel'));
    }

    public function update(Request $request, Artikel $artikel)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'solution_titles' => 'required|array',
            'solution_descriptions' => 'required|array',
            'solution_icons' => 'nullable|array',
            'solution_titles.*' => 'required|string|max:255',
            'solution_descriptions.*' => 'required|string',
            'solution_icons.*' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        // Upload main image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = Str::random(7) . "_" . Auth::id() . "_" . $image->getClientOriginalName();
            $image->move(public_path('artikel_images'), $name);
            $imagePath = $name;
        } else {
            $imagePath = $artikel->image_path;
        }

        // Upload main icon
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $name = Str::random(7) . "_" . Auth::id() . "_" . $icon->getClientOriginalName();
            $icon->move(public_path('artikel_icons'), $name);
            $iconPath = $name;
        } else {
            $iconPath = $imagePath = $artikel->icon_path;;
        }

        // Save Artikel
        $update = $artikel->update([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'icon_path' => $iconPath,
        ]);

        if ($update) {
            # code...
        }

        $titles = $request->input('solution_titles');
        $id = $request->input('solution_ids');
        $descriptions = $request->input('solution_descriptions');
        $icons = $request->file('solution_icons', []);

        // Save each Solution
        for ($i = 0; $i < count($titles); $i++) {
            $sol_data = Solutions::findOrFail($id[$i]);
            if ($sol_data) {
                $iconFile = $icons[$i] ?? null;
                $iconSolutionPath = null;

                if ($iconFile) {
                    $name = Str::random(7) . "_" . Auth::id() . "_" . $iconFile->getClientOriginalName();
                    $iconFile->move(public_path('solution_icons'), $name);
                    $iconSolutionPath = $name;
                } else {
                    $iconSolutionPath = $sol_data->icon_path;
                }

                $sol_update = $sol_data->update([
                    'title' => $titles[$i],
                    'description' => $descriptions[$i],
                    'icon_path' => $iconSolutionPath,
                ]);
            } else {
                return redirect()->route('admin.artikels.index')->with('gagal', 'Artikel gagal diperbarui.');
            }
        }

        return redirect()->route('admin.artikels.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Artikel $artikel)
    {
        $artikel->delete();
        return redirect()->route('admin.artikels.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
