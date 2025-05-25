<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RainfallData;
use App\Models\WeatherStation;
use Carbon\Carbon;
use App\Models\Artikel; // Ganti dari Rekomendasi ke Artikel
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $artikels = Artikel::with('solutions')
            ->whereNotNull('title')
            ->whereNotNull('description')
            ->get();

        $judulUtama = [
            'Pindahkan Barang Elektronik',
            'Ikuti Info Resmi',
            'Matikan Listrik Saat Banjir',
            'Langkah Cerdas Saat Banjir',
            'Siapkan Tas Darurat',
        ];

        $statis = $artikels->filter(function ($a) use ($judulUtama) {
            return in_array($a->title, $judulUtama);
        });

        $dinamis = $artikels->reject(function ($a) use ($judulUtama) {
            return in_array($a->title, $judulUtama);
        });

        $rekomendasis = collect($statis)->values()->merge($dinamis)->values();

        // Manual paginate
        $perPage = 4;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $rekomendasis->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginated = new LengthAwarePaginator(
            $currentItems,
            $rekomendasis->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Untuk Informasi Cuaca
        $defaultLocation = 'Bandung City';
        $station = WeatherStation::where('location', 'like', "%$defaultLocation%")->first();
        $rainfall = null;
        if ($station) {
            $rainfall = RainfallData::where('weather_station_id', $station->id)->whereDate('date', Carbon::today())->latest('date')->first();
}

        return view('user.dashboard', ['rekomendasis' => $paginated,'rainfall' => $rainfall, 'locationName' => $defaultLocation]);
    }
}
