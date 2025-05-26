<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FloodHistory; 
use Illuminate\Http\Request;

class FloodHistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $floods = FloodHistory::latest()
            ->when($search, function ($query, $search) {
                $query->where('location', 'like', '%' . $search . '%');
            })
            ->paginate(10); 
        return view('user.flood_history.index', compact('floods', 'search'));
    }
}