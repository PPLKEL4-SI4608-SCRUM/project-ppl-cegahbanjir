<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenWeatherService
{
    private $apiKey;
    private $baseUrl = 'https://api.openweathermap.org/data/2.5';

    public function __construct()
    {
        $this->apiKey = config('services.openweather.api_key', 'a5c0c5817331d879cf62fa61680cb03f');
    }

    /**
     * Ambil data cuaca saat ini (current weather)
     */
    public function getCurrentRainfallData($latitude, $longitude)
    {
        try {
            $response = Http::get("{$this->baseUrl}/weather", [
                'lat' => $latitude,
                'lon' => $longitude,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ]);

            if ($response->successful()) {
                $data = $response->json();

                $rainfall = $data['rain']['1h'] ?? 0;
                $intensity = $rainfall > 0 ? round($rainfall / 1, 2) : 0;

                return [
                    'date' => now()->format('Y-m-d'),
                    'rainfall_amount' => round($rainfall, 2),
                    'intensity' => $intensity,
                    'type' => 'current'
                ];
            } else {
                \Log::error('Gagal ambil current weather: ' . $response->body());
            }
        } catch (\Exception $e) {
            \Log::error('Error ambil cuaca saat ini: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Klasifikasi intensitas curah hujan
     */
    public function classifyRainfall($amount)
    {
        if ($amount == 0) {
            return 'tidak_hujan';
        } elseif ($amount <= 5) {
            return 'rendah';
        } elseif ($amount <= 20) {
            return 'sedang';
        } elseif ($amount <= 50) {
            return 'tinggi';
        } else {
            return 'sangat_tinggi';
        }
    }
}
