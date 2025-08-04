<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumen';

    protected $fillable = [
        'user_id', 
        'syarat_id', 
        'file_path',
        'status',
        'feedback',
        'tanggal_wawancara',
        'lokasi_wawancara',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function syarat()
    {
        return $this->belongsTo(Syarat::class);
    }
}
