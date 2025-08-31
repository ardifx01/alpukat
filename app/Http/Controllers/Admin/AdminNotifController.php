<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class AdminNotifController extends Controller
{
    public function notifikasiAdmin(Request $request)
    {
        // Ambil user yang login
        $uid = $request->user()->id;

        // Ambil semua notifikasi milik user, kemudian diurutkan dari yang terbaru
        $notif = Notifikasi::where('user_id', $uid)
            ->latest()
            ->get();

        // Tandai semua notifikasi "belum dibaca" menjadi "sudah dibaca"
        Notifikasi::where('user_id', $uid)
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return view('admin.notifications.index', compact('notif'));
    }
}
