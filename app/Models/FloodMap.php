<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloodMap extends Model
{
    protected $fillable = [
        'wilayah',
        'polygons'
    ];

    protected $casts = [
        'polygons' => 'array'
    ];
}
