<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloodMap extends Model
{
    use HasFactory;

    protected $fillable = ['wilayah', 'latitude', 'longitude', 'gambar'];
}
