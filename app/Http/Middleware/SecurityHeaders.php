<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Only apply to web/html responses
        $contentType = $response->headers->get('Content-Type', '');
        $isHtml = str_contains($contentType, 'text/html');
        $routeName = optional($request->route())->getName();
        $isPreviewRoute = in_array($routeName, ['dokumen.preview', 'admin.dokumen.preview']);
        $isEmbeddableDoc = str_starts_with($contentType, 'application/pdf') || str_starts_with($contentType, 'image/');

        // Clickjacking protection
        // Allow SAMEORIGIN specifically for our document preview endpoints (PDF/images) so they render in iframe.
        if ($isPreviewRoute && $isEmbeddableDoc) {
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        } else {
            $response->headers->set('X-Frame-Options', 'DENY');
        }
        // MIME sniffing protection
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        // Referrer policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        // Permissions policy (restrict powerful features)
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=(), payment=()');

        // Content Security Policy
        // Apply strict(er) CSP in production; skip in local/dev to avoid blocking Vite/inline tooling
        if ($isHtml && app()->environment('production')) {
            // Notes:
            // - 'unsafe-inline' allowed for styles (Tailwind utility tweaks) and scripts (Alpine directives)
            // - 'unsafe-eval' included due to Alpine.js using Function constructor in expressions
            // - Allow https: for CDN assets (e.g., Chart.js, fonts) if used
            $csp = implode('; ', [
                "default-src 'self'",
                "img-src 'self' data: blob: https:",
                "style-src 'self' 'unsafe-inline' https:",
                "font-src 'self' data: https:",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https:",
                "connect-src 'self' https:",
                "frame-ancestors 'none'",
            ]);
            $response->headers->set('Content-Security-Policy', $csp);
        }

        // HSTS should be set at the proxy (Nginx). Set here only if over HTTPS.
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
