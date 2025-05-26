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
        'date',
        'category',
        'rainfall_amount',
        'intensity',
        'updated_by',
        'added_by',          
        'data_source'        
    ];

    protected $casts = [
        'date' => 'date',
        'rainfall_amount' => 'decimal:2',
        'intensity' => 'decimal:2'
    ];

    public function weatherStation(): BelongsTo
    {
        return $this->belongsTo(WeatherStation::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function addedBy(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function getCategoryBadgeClass(): string
    {
        return match($this->category) {
            'rendah' => 'bg-green-500',
            'sedang' => 'bg-yellow-500',
            'tinggi' => 'bg-orange-500',
            'sangat_tinggi' => 'bg-red-500',
            default => 'bg-gray-500'
        };
    }

    public function getCategoryLabel(): string
    {
        return match($this->category) {
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi',
            'sangat_tinggi' => 'Sangat Tinggi',
            default => 'Tidak Diketahui'
        };
    }
}
