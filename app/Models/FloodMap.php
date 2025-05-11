<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloodMap extends Model
{
    protected $fillable = [
        'wilayah',
        'latitude',
        'longitude',
        'polygon_coordinates',
        'tingkat_risiko',
    ];

    protected $casts = [
        'polygon_coordinates' => 'array',
    ];
}
