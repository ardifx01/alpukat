<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function notifikasi()
    {
        $userId = Auth::id();

        // Ambil semua notifikasi user
        $notifikasi = Notifikasi::where('user_id', $userId)->latest()->get();

        // Tandai semua notifikasi yang belum dibaca sebagai dibaca
        Notifikasi::where('user_id', $userId)->where('dibaca', false)->update(['dibaca' => true]);

        return view('user.notifikasi', compact('notifikasi'));
    }
}
