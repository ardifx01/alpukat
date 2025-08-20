<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfilAdminController extends Controller
{
    public function profilAdmin()
    {
        $admin = Auth::user();

        return view('admin.profil.index', compact('admin'));
    }
}

