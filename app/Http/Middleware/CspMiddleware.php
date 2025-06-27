<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Symfony\Component\HttpFoundation\Response;

class CspMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Base policies
        $policies = [
            'default-src' => "'self'",
            'style-src'   => "'self' 'unsafe-inline' https://fonts.bunny.net https://fonts.googleapis.com",
            'font-src'    => "'self' https://fonts.bunny.net https://fonts.gstatic.com",
            'img-src'     => "'self' data:",
            'object-src'  => "'none'",
            'base-uri'    => "'self'",
            'form-action' => "'self'",
            'frame-ancestors' => "'none'",
            // Allow unsafe-eval for Alpine.js, unsafe-inline for scripts injected by Vite/Blade
            'script-src'  => "'self' 'unsafe-eval' 'unsafe-inline'",
            // Allow connections for HMR
            'connect-src' => "'self'",
        ];

        // If we are in a local environment, add the Vite development server to the CSP
        if (app()->isLocal() && Vite::isRunningHot()) {
            $vite_host = parse_url(Vite::asset('/'), PHP_URL_HOST) . ':' . parse_url(Vite::asset('/'), PHP_URL_PORT);

            $policies['script-src'] .= " {$vite_host}";
            $policies['style-src']  .= " {$vite_host}";
            $policies['connect-src'].= " ws://{$vite_host} {$vite_host}";
            $policies['font-src']   .= " {$vite_host}";
        }

        $header = [];
        foreach($policies as $directive => $value) {
            $header[] = "{$directive} {$value}";
        }

        $response->headers->set('Content-Security-Policy', implode('; ', $header));

        return $response;
    }
}
