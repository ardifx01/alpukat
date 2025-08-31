<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->user_type == "user") {
            return view('user.dashboard');
        } else if (Auth::check() && Auth::user()->user_type == "admin") {
            return view('admin.dashboard');
        }
    }
}
