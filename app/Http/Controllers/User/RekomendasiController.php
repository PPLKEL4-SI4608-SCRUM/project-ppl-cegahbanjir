<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RekomendasiController extends Controller
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

        // PAGINATE MANUALLY
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

        return view('user.rekomendasi.index', ['rekomendasis' => $paginated]);
    }


    public function detail($id)
    {
        $rekomendasi = Artikel::with('solutions')->findOrFail($id);
        return view('rekomendasi.show', compact('rekomendasi'));
    }
}
