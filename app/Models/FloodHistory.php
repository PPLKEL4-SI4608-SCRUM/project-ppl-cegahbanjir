<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloodHistory extends Model
{
    protected $table = 'flood_histories';
    protected $fillable = [
        'location',
        'date',
        'impact',
        'images'
    ];  
}