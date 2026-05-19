<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware d'Audit Logging
 * 
 * Enregistre les actions sensibles:
 * - Modifications de données (PUT, DELETE, PATCH)
 * - Accès aux zones admin
 * - Tentatives d'accès non-autorisées
 */
class AuditLoggingMiddleware
{
    /**
     * Propriétés sensibles qui doivent être loggées lors d'une modification
     */
    private array $sensitiveFields = [
        'email', 'password', 'phone', 'role', 'is_admin',
        'google_id', 'google_token', 'cv', 'photo',
        'title', 'description', 'status'
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Enregistrer les opérations sensibles (avec gestion d'erreur)
        try {
            if ($this->isSensitiveOperation($request)) {
                $this->logSensitiveAction($request, $response);
            }
        } catch (\Exception $e) {
            // Ignorer les erreurs de logging pour ne pas casser les requêtes
        }

        // Enregistrer les accès à l'admin (avec gestion d'erreur)
        try {
            if ($request->is('admin/*')) {
                $this->logAdminAccess($request);
            }
        } catch (\Exception $e) {
            // Ignorer les erreurs de logging
        }

        // Enregistrer les tentatives d'accès non-autorisées (avec gestion d'erreur)
        try {
            if (method_exists($response, 'status') && $response->status() == 403) {
                $this->logUnauthorizedAccess($request);
            }
        } catch (\Exception $e) {
            // Ignorer les erreurs de logging
        }

        return $response;
    }

    /**
     * Vérifier si c'est une opération sensible
     */
    private function isSensitiveOperation(Request $request): bool
    {
        return in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE']) &&
               !str_contains($request->path(), 'api/articles/search');
    }

    /**
     * Enregistrer les actions sensibles
     */
    private function logSensitiveAction(Request $request, Response $response): void
    {
        $user = Auth::user();
        $changedFields = array_intersect_key(
            $request->all(),
            array_flip($this->sensitiveFields)
        );

        if (!empty($changedFields)) {
            // Masquer les mots de passe
            if (isset($changedFields['password'])) {
                $changedFields['password'] = '[REDACTED]';
            }

            Log::channel('audit')->info('Sensitive action performed', [
                'user_id' => $user?->id,
                'user_email' => $user?->email,
                'method' => $request->method(),
                'path' => $request->path(),
                'changed_fields' => array_keys($changedFields),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'http_status' => $response->status(),
                'timestamp' => now(),
            ]);
        }
    }

    /**
     * Enregistrer les accès admin
     */
    private function logAdminAccess(Request $request): void
    {
        $user = Auth::user();
        
        Log::channel('audit')->info('Admin area accessed', [
            'user_id' => $user?->id,
            'user_email' => $user?->email,
            'is_admin' => $user?->is_admin,
            'path' => $request->path(),
            'method' => $request->method(),
            'ip_address' => $request->ip(),
            'timestamp' => now(),
        ]);
    }

    /**
     * Enregistrer les tentatives d'accès non-autorisées
     */
    private function logUnauthorizedAccess(Request $request): void
    {
        Log::channel('audit')->warning('Unauthorized access attempt', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()?->email,
            'path' => $request->path(),
            'method' => $request->method(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now(),
        ]);
    }
}
