<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $fillable = [
        'user_id',
        'verifikasi_id',
        'pesan',
        'dibaca',
    ];

    public function user()
    {
        return $this->beongsTo(User::class);
    }

    public function verifikasi() 
    {
        return $this->belongsTo(Verifikasi::class);
    }
}
