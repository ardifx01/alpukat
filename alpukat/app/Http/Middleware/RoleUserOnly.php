<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ← Tambahan penting
use Symfony\Component\HttpFoundation\Response;

class RoleUserOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->user_type === 'user') {
            return $next($request);
        }

        abort(403, 'Akses hanya untuk pihak koperasi.');
    }
}
