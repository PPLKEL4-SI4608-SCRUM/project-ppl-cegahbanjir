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
        $features = FloodMap::whereNotNull('polygons')->get()->flatMap(function ($map) {
            $polygonData = is_array($map->polygons) ? $map->polygons : json_decode($map->polygons, true);

            return collect($polygonData)->map(function ($poly) use ($map) {
                return [
                    'type' => 'Feature',
                    'properties' => [
                        'wilayah' => $map->wilayah,
                        'tingkat' => $poly['tingkat_risiko'] ?? 'tidak diketahui'
                    ],
                    'geometry' => [
                        'type' => 'Polygon',
                        'coordinates' => [
                            $poly['coordinates'] ?? []
                        ]
                    ]
                ];
            });
        });

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features
        ]);
    }
}
