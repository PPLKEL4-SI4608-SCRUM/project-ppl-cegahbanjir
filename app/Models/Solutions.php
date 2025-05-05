<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solutions extends Model
{
    use HasFactory;

    protected $fillable = [
        'artikel_id',
        'title',
        'description',
        'icon_path'
    ];

    // Relasi: solusi milik satu artikel
    public function artikel()
    {
        return $this->belongsTo(Artikel::class);
    }
}
