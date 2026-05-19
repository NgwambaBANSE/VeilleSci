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

            // ✅ SECURITY FIX #15: Vérifier que l'email a été vérifié par Google
            if (!$googleUser->user['email_verified']) {
                return redirect('/login')->with('error', 'Votre email Google n\'est pas vérifié. Veuillez vérifier votre email et réessayer.');
            }

            $user = User::where('google_id', $googleUser->id)->first();

            if (!$user) {
                $user = User::where('email', $googleUser->email)->first();

                if ($user) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'google_token' => $googleUser->token,
                        'avatar' => $googleUser->avatar,
                        'email_verified_at' => now(), // Marquer comme vérifié puisque Google l'a vérifié
                    ]);
                } else {
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'google_token' => $googleUser->token,
                        'avatar' => $googleUser->avatar,
                        'email_verified_at' => now(), // Marquer comme vérifié puisque Google l'a vérifié
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
