<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FloodPrediction;
use App\Models\RainfallData;
use App\Models\WeatherStation;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class WeatherDashboardController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->input('search');

        if (!$city) {
            return view('user.weather', [
                'city' => '',
                'stations' => [],
                'rainfalls' => [],
                'predictions' => [],
                'forecast7days' => [],
                'notifications' => null,
                'twitterShareUrl' => '',
                'notificationMessage' => '',
                'stationName' => '',
                'stationLocation' => ''
            ]);
        }

        $stations = WeatherStation::where(function ($query) use ($city) {
            $query->where('name', 'like', "%$city%")
                ->orWhere('location', 'like', "%$city%");
        })->orderBy('name')->get();

        $stationIds = $stations->pluck('id');

        $rainfalls = RainfallData::with('weatherStation')
            ->whereIn('weather_station_id', $stationIds)
            ->latest()
            ->take(5)
            ->get();

        $predictions = FloodPrediction::with('weatherStation')
            ->whereIn('weather_station_id', $stationIds)
            ->latest()
            ->take(5)
            ->get();

        $notifications = Notification::latest()->first();
        $weatherStation = $notifications ? $notifications->weatherStation : null;
        $stationName = $weatherStation ? $weatherStation->name : 'Stasiun Tidak Dikenal';
        $stationLocation = $weatherStation ? $weatherStation->location : 'Lokasi Tidak Dikenal';
        $notificationMessage = "Peringatan banjir untuk wilayah " . $stationName . " yang terletak di " . $stationLocation . ". Harap waspada!";
        $twitterShareUrl = "https://twitter.com/intent/tweet?text=" . urlencode($notificationMessage);

        $forecast7days = [];

        if ($stations->isNotEmpty()) {
            try {
                $apiKey = env('OPENWEATHER_API_KEY');
                $response = Http::get("https://api.openweathermap.org/data/2.5/forecast", [
                    'q' => $city,
                    'units' => 'metric',
                    'appid' => $apiKey,
                    'lang' => 'id'
                ]);

                if ($response->successful()) {
                    $data = $response->json()['list'];

                    // Kelompokkan per tanggal
                    $grouped = collect($data)->groupBy(function ($item) {
                        return Carbon::parse($item['dt_txt'])->format('Y-m-d');
                    });

                    // Ambil hanya tanggal mulai besok (bukan hari ini)
                    $forecast7days = $grouped->filter(function ($items, $date) {
                        return Carbon::parse($date)->greaterThanOrEqualTo(Carbon::tomorrow());
                    })->map(function ($items, $date) {
                        return [
                            'dt' => $date,
                            'weather' => $items[0]['weather'],
                            'temp' => [
                                'max' => collect($items)->max('main.temp_max'),
                                'min' => collect($items)->min('main.temp_min')
                            ],
                            'rain' => collect($items)->sum(function ($i) {
                                return $i['rain']['3h'] ?? 0;
                            })
                        ];
                    })->take(5)->values()->toArray();
                }
            } catch (\Exception $e) {
                $forecast7days = [];
            }
        }

        return view('user.weather', compact(
            'city',
            'stations',
            'rainfalls',
            'predictions',
            'forecast7days',
            'notifications',
            'twitterShareUrl',
            'notificationMessage',
            'stationName',
            'stationLocation'
        ));
    }
}
