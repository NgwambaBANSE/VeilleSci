<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier que l'utilisateur est authentifié
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Veuillez vous connecter pour accéder à cette zone.');
        }

        // Recharger l'utilisateur depuis la base de données pour s'assurer que les données sont à jour
        $user = auth()->user();
        $user->refresh();

        // Vérifier le statut administrateur
        if (!$user->is_admin) {
            \Log::warning('Tentative d\'accès non autorisé à la zone admin', [
                'user_id' => $user->id,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
                'path' => $request->path(),
            ]);
            
            return redirect('/app')
                ->with('error', 'Vous n\'avez pas les permissions pour accéder à cette zone. Seuls les administrateurs y ont accès.');
        }

        return $next($request);
    }
}
