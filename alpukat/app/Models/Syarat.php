<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syarat extends Model
{

    protected $table = 'syarat';

    // Optional kalau fillable (kalau pakai $fillable atau mass assignment)
    protected $fillable = [
        'nama_syarat',
        'kategori_syarat',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];
}
