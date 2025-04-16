<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WeatherStation;

class Notification extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory;

    protected $fillable =['weather_station_id','is_sent'];
    public function weatherStation()
    {
        return $this->belongsTo(WeatherStation::class);
    }

}
