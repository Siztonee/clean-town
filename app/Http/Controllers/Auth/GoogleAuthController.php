<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect('/')->with('error', 'Google authentication failed.');
        }

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            Auth::login($existingUser);
            if (empty($existingUser->google_id)) {
                $existingUser->update([
                    "google_id" => $user->getId()
                ]);
            }
        } else {
            $newUser = User::updateOrCreate([
                'email' => $user->email
            ], [
                'username' => $user->name,
                'password' => bcrypt(Str::random(16)), 
                'email_verified_at' => now()
            ]);
            Auth::login($newUser);
        }

        return redirect()->route('home.index');
    }
}
