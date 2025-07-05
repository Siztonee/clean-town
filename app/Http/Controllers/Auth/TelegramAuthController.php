<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TelegramAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('telegram')->redirect();
    }

    public function callback()
    {
        try {
            $user = Socialite::driver('telegram')->user();
        } catch (Throwable $e) {
            return redirect('/login')->with('error', 'Telegram authentication failed.');
        }

        $existingUser = User::where('telegram_id', $user->getId())->first();
        
        if ($existingUser) {
            Auth::login($existingUser);
            if (empty($existingUser->telegram_id)) {
                $existingUser->update([
                    "telegram_id" => $user->getId()
                ]);
            }
        } else {
            $newUser = User::updateOrCreate([
                'telegram_id' => $user->getId()
            ], [
                'username' => $user->name,
                'password' => bcrypt(Str::random(16)), 
                'phone_verified_at' => now()
            ]);

            Auth::login($newUser);
        }

        return redirect()->route('home.index');

    }
}
