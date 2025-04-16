<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeatherStation;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function create()
    {
        // Ambil semua stasiun cuaca, bukan notifikasi
        $weatherStations = WeatherStation::all();
        return view('admin.weather.notification.create', compact('weatherStations'));
    }
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'weather_station_id' => 'required|exists:weather_stations,id',
        ]);
    
        // Menyimpan notifikasi dengan status tidak terkirim (default)
        $notification = Notification::create([
            'weather_station_id' => $validated['weather_station_id'],
            'is_sent' => false, // Status awal notifikasi belum terkirim
        ]);
    
        // Mengupdate status notifikasi menjadi terkirim
        $notification->update(['is_sent' => true]);
    
        // Menyimpan pesan flash untuk ditampilkan di alert (pada pengguna)
        session()->flash('alert', 'Notifikasi banjir telah berhasil dikirim ke pengguna.');
    
        // Redirect ke halaman sebelumnya (halaman admin)
        return redirect()->route('admin.weather.notification.create');
    }
    

}
