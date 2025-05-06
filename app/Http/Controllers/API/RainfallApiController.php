<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class RainfallApiController extends Controller
{
    public function getCurrentRainfall()
    {
        $lat = 7.0909;
        $lon = 107.6689;
        $apiKey = 'a5c0c5817331d879cf62fa61680cb03f';

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $apiKey,
            'units' => 'metric',
        ]);

        if (!$response->successful()) {
            return response()->json(['error' => 'Gagal ambil data dari API'], 500);
        }

        $data = $response->json();

        $rainfall = $data['rain']['1h'] ?? 0; // mm per jam

        return response()->json(['rainfall' => $rainfall]);
    }
}
