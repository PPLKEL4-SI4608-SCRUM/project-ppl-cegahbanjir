<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',  
        'icon_path'    
    ];

    // Relasi: 1 Artikel punya banyak solusi
    public function solutions()
    {
        return $this->hasMany(Solutions::class);
    }
}
