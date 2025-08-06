<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class UserController extends Controller
{
    public function index(){
        if(Auth::check() && Auth::user()->user_type=="user"){
            return view('dashboard');
        }
        else if(Auth::check() && Auth::user()->user_type=="admin"){
            return view('admin.dashboard');
        }
    }

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
