<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Menampilkan form edit profil
    public function edit(): View
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    // Update data profil
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Isi field teks yang lolos validasi
        $user->fill($request->safe()->only(['name', 'email', 'alamat']));

        // Reset verifikasi jika email berubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle upload avatar (opsional)
        if ($request->hasFile('avatar')) {
            // hapus avatar lama jika ada
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_path = $path;
        }

        $user->save();

        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    // Menampilkan profil
    public function show()
    {
        return view('user.profile.show');
    }
}
