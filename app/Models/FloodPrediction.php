<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FloodPrediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'weather_station_id',
        'prediction_date',
        'risk_level',
        'predicted_rainfall',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'prediction_date' => 'date',
    ];

    public function weatherStation(): BelongsTo
    {
        return $this->belongsTo(WeatherStation::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
