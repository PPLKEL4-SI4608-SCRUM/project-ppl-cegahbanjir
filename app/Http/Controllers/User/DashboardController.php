<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RainfallData;
use App\Models\FloodMap;
use App\Models\WeatherStation;
use Carbon\Carbon;
use App\Models\Artikel;
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

        $defaultLocation = 'Bandung City';
        $station = WeatherStation::where('location', 'like', "%$defaultLocation%")->first();
        $rainfall = null;
        if ($station) {
            $rainfall = RainfallData::where('weather_station_id', $station->id)->whereDate('date', Carbon::today())->latest('date')->first();
        }
        $maps = FloodMap::all();

        $peringatanDini = [];
        foreach ($maps as $map) {
            $polygonData = is_array($map->polygons) ? $map->polygons : json_decode($map->polygons, true);
            // Tambahkan pengecekan jika $polygonData null atau tidak valid
            if (empty($polygonData) || !is_array($polygonData)) {
                continue;
            }
            $risikos = collect($polygonData)->pluck('tingkat_risiko')->filter()->unique()->toArray();
            foreach ($risikos as $tingkat) {
                $peringatan = '';
                if (strtolower($tingkat) === 'sangat tinggi') {
                    $peringatan = 'Siaga';
                } elseif (strtolower($tingkat) === 'tinggi') {
                    $peringatan = 'Waspada';
                } else {
                    continue;
                }
                $peringatanDini[] = [
                    'lokasi' => $map->wilayah,
                    'peringatan' => $peringatan,
                ];
            }
        }

        
        $mainTwitterShareUrl = "https://twitter.com/intent/tweet?text=" . urlencode("Cek info peringatan banjir terkini dari CeBan (Cegah Banjir)!"); 
        $shareMessage = "Info Peringatan Banjir dari CeBan: ";

        if (!empty($peringatanDini)) {
            $peringatanMessages = [];
            foreach ($peringatanDini as $key => $item) {
                $peringatanMessages[] = "Wilayah {$item['lokasi']} status {$item['peringatan']}";
            }
            if (count($peringatanMessages) > 0) {
                $shareMessage .= implode(', ', array_slice($peringatanMessages, 0, 2)); 
                if (count($peringatanMessages) > 2) {
                    $shareMessage .= " dan lainnya.";
                }
                $shareMessage .= " Harap waspada!";
            } else {
                 $shareMessage = "Tidak ada peringatan banjir aktif (Siaga/Waspada) saat ini. Tetap pantau informasi dari CeBan!";
            }
            $mainTwitterShareUrl = "https://twitter.com/intent/tweet?text=" . urlencode($shareMessage);
        }

        $notificationMessages = [];
         foreach ($peringatanDini as $item) {
             $notificationMessage = "Peringatan banjir untuk wilayah {$item['lokasi']}. Tingkat risiko {$item['peringatan']}. Harap waspada!";
             $individualTwitterShareUrl = "https://twitter.com/intent/tweet?text=" . urlencode($notificationMessage);
             $notificationMessages[] = [
                 'message' => $notificationMessage,
                 'twitterShareUrl' => $individualTwitterShareUrl,
             ];
         }

        return view('user.dashboard', [
            'rekomendasis' => $paginated,
            'rainfall' => $rainfall,
            'locationName' => $defaultLocation,
            'maps' => $maps,
            'peringatanDini' => $peringatanDini,
            // 'notificationMessages' => $notificationMessages, 
            'twitterShareUrl' => $mainTwitterShareUrl, 
        ]);
    }
}