<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisasterReport extends Model
{
    protected $fillable = [
        'user_id',
        'location',
        'description',
        'status',
        'disaster_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}