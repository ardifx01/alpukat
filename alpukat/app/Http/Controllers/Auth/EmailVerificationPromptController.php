<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(Request $request): View|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            $route = $request->user()->user_type === 'admin'
                ? 'admin.dashboard'
                : 'user.dashboard';

            return redirect()->intended(route($route));
        }

        return view('auth.verify-email');
    }
}
