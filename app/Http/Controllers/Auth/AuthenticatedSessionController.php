<?php
// Ouvrez ce fichier et trouvez la méthode store()
// Remplacez la ligne de redirection par :

// AVANT (généré par Breeze) :
// return redirect()->intended(RouteServiceProvider::HOME);

// APRÈS :
// return redirect()->intended('/app');

// ─────────────────────────────────────────────────────────
// Fichier complet modifié :

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // ← Redirige vers /app après connexion
        return redirect()->intended('/app');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ← Redirige vers l'accueil après déconnexion
        return redirect('/');
    }
}