<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;
use App\Http\Controllers\Controller;

class NotifikasiController extends Controller
{
    public function notifikasiUser()
    {
        $userId = Auth::id();

        // Ambil semua notifikasi user
        $notifikasi = Notifikasi::where('user_id', $userId)->latest()->get();

        // Tandai semua notifikasi yang belum dibaca sebagai dibaca
        Notifikasi::where('user_id', $userId)->where('dibaca', false)->update(['dibaca' => true]);

        return view('user.notifikasi', compact('notifikasi'));
    }
}
