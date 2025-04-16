<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeatherStation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'latitude',
        'longitude',
        'status',
    ];

    public function rainfallData(): HasMany
    {
        return $this->hasMany(RainfallData::class);
    }

    public function floodPredictions(): HasMany
    {
        return $this->hasMany(FloodPrediction::class);
    }

    public function warningParameters(): HasMany
    {
        return $this->hasMany(FloodWarningParameter::class);
    }
}
