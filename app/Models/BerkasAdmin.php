<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasAdmin extends Model
{
    use HasFactory;

    protected $fillable = [
        'verifikasi_id',
        'user_id',
        'jenis_surat',
        'file_path',
    ];

    public function verifikasi()
    {
        return $this->belongsTo(Verifikasi::class, 'verifikasi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
