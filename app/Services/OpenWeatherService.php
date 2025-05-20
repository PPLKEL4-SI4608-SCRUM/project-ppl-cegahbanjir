<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenWeatherService
{
    protected $apiKey;
    protected $defaultLat;
    protected $defaultLon;

    public function __construct()
    {
        $this->apiKey = config('services.openweather.key');
        $this->defaultLat = config('services.openweather.lat');
        $this->defaultLon = config('services.openweather.lon');
    }

    /**
     * Ambil curah hujan real-time dari koordinat tertentu.
     * Jika tidak ada parameter, gunakan default dari config.
     */
    public function getCurrentRainfall($lat = null, $lon = null)
    {
        $lat = $lat ?? $this->defaultLat;
        $lon = $lon ?? $this->defaultLon;

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $this->apiKey,
            'units' => 'metric'
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Ambil curah hujan 1 jam terakhir, jika tidak tersedia default ke 0
            return $data['rain']['1h'] ?? 0;
        }

        return null;
    }
}
