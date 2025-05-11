<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FloodMap;
use Illuminate\Http\Request;

class MapDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = FloodMap::query();

        if ($request->has('search') && $request->search !== '') {
            $query->where('wilayah', 'like', '%' . $request->search . '%');
        }

        $maps = $query->get();
        return view('user.map', compact('maps'));
    }

    public function geojson()
    {
        $features = FloodMap::whereNotNull('polygon_coordinates')->get()->map(function ($map) {
            return [
                'type' => 'Feature',
                'properties' => [
                    'wilayah' => $map->wilayah,
                    'tingkat' => $map->tingkat_risiko
                ],
                'geometry' => [
                    'type' => 'Polygon',
                    'coordinates' => [json_decode($map->polygon_coordinates)]
                ]
            ];
        });

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features
        ]);
    }
}
