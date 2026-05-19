<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de Sécurité
 * 
 * Ajoute les en-têtes de sécurité essentiels pour protéger contre:
 * - XSS (Cross-Site Scripting)
 * - Clickjacking
 * - MIME-type sniffing
 * - Content Security Policy
 * - Strict Transport Security
 */
class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Empêcher le clickjacking (cliquer sur un bouton invisible)
        $response->header('X-Frame-Options', 'DENY');

        // Empêcher le MIME-type sniffing (sécurité basée sur le contenu)
        $response->header('X-Content-Type-Options', 'nosniff');

        // Activer la protection XSS du navigateur
        $response->header('X-XSS-Protection', '1; mode=block');

        // Politique de référent stricte
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Content Security Policy (CSP) - stricte par défaut
        // En développement, relâcher CSP pour permettre Vite (qui peut utiliser IPv4, IPv6, ou localhost)
        if (app()->environment('local')) {
            // Mode DEV : CSP plus permissive pour Vite
            $csp = "default-src 'self' http: https:; "
                 . "script-src 'self' 'unsafe-inline' 'unsafe-eval' http: https:; "
                 . "style-src 'self' 'unsafe-inline' http: https:; "
                 . "img-src 'self' data: https:; "
                 . "font-src 'self' data: https://fonts.googleapis.com https://fonts.gstatic.com; "
                 . "connect-src 'self' http: https: ws: wss:; "
                 . "frame-ancestors 'none'; "
                 . "base-uri 'self'; "
                 . "form-action 'self'";
        } else {
            // Mode PRODUCTION : CSP stricte
            $csp = "default-src 'self'; "
                 . "script-src 'self'; "
                 . "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; "
                 . "img-src 'self' data: https:; "
                 . "font-src 'self' data: https://fonts.googleapis.com https://fonts.gstatic.com; "
                 . "connect-src 'self' https://apis.google.com; "
                 . "frame-ancestors 'none'; "
                 . "base-uri 'self'; "
                 . "form-action 'self'";
        }
        
        $response->header('Content-Security-Policy', $csp);

        // HSTS (forcer HTTPS pendant 1 an)
        if (app()->environment('production')) {
            $response->header(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        // Permissions Policy (Feature Policy)
        $response->header(
            'Permissions-Policy',
            'geolocation=(), microphone=(), camera=(), payment=(), usb=()'
        );

        return $response;
    }
}
