<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OpenWeatherService;
use App\Models\Rainfall;
use App\Models\WeatherStation;
use Illuminate\Support\Facades\Auth;

class FetchRainfallFromOpenWeather extends Command
{
    protected $signature = 'rainfall:fetch-openweather';
    protected $description = 'Fetch current rainfall data from OpenWeatherMap API and store it';

    protected $weatherService;

    public function __construct(OpenWeatherService $weatherService)
    {
        parent::__construct();
        $this->weatherService = $weatherService;
    }

    public function handle()
    {
        $this->info('Fetching rainfall data from OpenWeatherMap...');

        $rainfall = $this->weatherService->getCurrentRainfall();

        if ($rainfall === null) {
            $this->error('Gagal mendapatkan data dari API.');
            return;
        }

        // Pilih stasiun default
        $station = WeatherStation::first();
        if (!$station) {
            $this->error('Tidak ada stasiun cuaca yang tersedia.');
            return;
        }

        Rainfall::create([
            'weather_station_id' => $station->id,
            'recorded_at' => now(),
            'rainfall_amount' => $rainfall,
            'intensity' => $rainfall, // diasumsikan sama, nanti bisa dihitung
            'data_source' => 'api',
            'added_by' => 1, // bisa diganti dengan ID user sistem atau admin default
        ]);

        $this->info('Data curah hujan berhasil disimpan!');
    }
}
