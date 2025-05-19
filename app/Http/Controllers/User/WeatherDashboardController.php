<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FloodPrediction;
use App\Models\RainfallData;
use App\Models\WeatherStation;
use App\Models\Notification;
use Illuminate\Http\Request;

class WeatherDashboardController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->input('search', 'Bandung');

        // 🔍 Ambil stasiun yang cocok dengan input pencarian
        $stations = WeatherStation::where(function ($query) use ($city) {
            $query->where('name', 'like', "%$city%")
                ->orWhere('location', 'like', "%$city%");
        })->orderBy('name')->get();

        // Ambil ID stasiun yang cocok untuk curah hujan dan prediksi banjir
        $stationIds = $stations->pluck('id');

        // 🌧️ Curah hujan & Prediksi banjir hanya dari stasiun yang dicari
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


        $user = auth()->user();

        // Ambil notifikasi yang terkait dengan stasiun yang ditampilkan
        $notifications = Notification::latest()->first();

        // Ambil nama stasiun dan lokasi
        $weatherStation = $notifications ? $notifications->weatherStation : null;
        $stationName = $weatherStation ? $weatherStation->name : 'Stasiun Tidak Dikenal';
        $stationLocation = $weatherStation ? $weatherStation->location : 'Lokasi Tidak Dikenal';

        // Tentukan pesan notifikasi yang mencakup nama stasiun dan lokasi
        $notificationMessage = "Peringatan banjir untuk wilayah " . $stationName . " yang terletak di " . $stationLocation . ". Harap waspada!";
        
        // URL untuk berbagi ke Twitter dengan pesan notifikasi
        $twitterShareUrl = "https://twitter.com/intent/tweet?text=" . urlencode($notificationMessage);



        return view('user.weather', compact(
            'city',
            'stations',
            'rainfalls',
            'predictions',
            'notifications',
            'twitterShareUrl',
            'notificationMessage',
            'stationName',
            'stationLocation'
        ));

    }
}
