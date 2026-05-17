<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->id)->first();

            if (!$user) {
                $user = User::where('email', $googleUser->email)->first();

                if ($user) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'google_token' => $googleUser->token,
                        'avatar' => $googleUser->avatar,
                    ]);
                } else {
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'google_token' => $googleUser->token,
                        'avatar' => $googleUser->avatar,
                        'password' => bcrypt(str()->random(24)),
                    ]);
                }
            } else {
                $user->update([
                    'google_token' => $googleUser->token,
                    'avatar' => $googleUser->avatar,
                ]);
            }

            $user->update(['last_login_at' => now()]);

            Auth::login($user);

            return redirect('/app')->with('success', 'Connecté avec Google avec succès !');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Erreur lors de la connexion Google. Veuillez réessayer.');
        }
    }
}
