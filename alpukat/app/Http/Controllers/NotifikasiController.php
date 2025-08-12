<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

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

    public function notifikasiAdmin()
    {
        $adminId = Auth::id();
        // Nanti kalau admin pakai guard khusus, ganti jadi Auth::guard('admin')->id()

        // Ambil semua notifikasi untuk admin
        $notifikasi = Notifikasi::where('target_role', 'admin')->orderBy('created_at', 'desc')->paginate(10);

        // Tandai semua notifikasi yang belum dibaca sebagai dibaca
        Notifikasi::where('target_role', 'admin')->where('dibaca', false)->update(['dibaca' => true]);

        return view('admin.notifikasi.index', compact('notifikasi'));
    }
}
