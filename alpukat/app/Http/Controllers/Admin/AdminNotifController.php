<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class AdminNotifController extends Controller
{
    public function notifikasiAdmin(Request $request)
    {
        $uid = $request->user()->id;

        $notif = Notifikasi::where('user_id', $uid)
            ->latest()
            ->get();

        Notifikasi::where('user_id', $uid)->where('dibaca', false)->update(['dibaca' => true]);

        return view('admin.notifications.index', compact('notif'));
    }
}
