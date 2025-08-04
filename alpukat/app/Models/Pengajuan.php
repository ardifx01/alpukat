<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifikasi()
    {
        return $this->hasOne(Verifikasi::class);
    }

}
