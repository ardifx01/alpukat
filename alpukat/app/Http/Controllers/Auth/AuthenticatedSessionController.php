<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();

        // Ambil (dan kosongkan) intended url dari session
        $intended = $request->session()->pull('url.intended'); // bisa null

        // Jika admin:
        if ($user->user_type === 'admin') {
            // Kalau intended-nya memang /admin*, kirim ke sana; kalau tidak, ke dashboard admin
            if ($intended && Str::startsWith(parse_url($intended, PHP_URL_PATH) ?? '', '/admin')) {
                return redirect()->to($intended);
            }
            return redirect()->route('admin.dashboard');
        }

        // BUKAN admin: selalu ke dashboard user, abaikan intended /admin
        return redirect()->route('user.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
