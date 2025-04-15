<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RainfallData extends Model
{
    use HasFactory;

    protected $fillable = [
        'weather_station_id',
        'recorded_at',
        'rainfall_amount',
        'intensity',
        'data_source',
        'added_by',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function weatherStation(): BelongsTo
    {
        return $this->belongsTo(WeatherStation::class);
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}