<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withCommands([
        \App\Console\Commands\MigrateDokumenToPrivate::class,
        \App\Console\Commands\RenameDokumenDeterministic::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust proxy headers for HTTPS and proxy setup
        $middleware->trustProxies(at: [
            '10.10.10.9',    // Nginx Proxy Manager IP
            '127.0.0.1',     // Localhost
            '10.10.10.0/24', // Local network range
        ]);
        
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'profile.completed' => \App\Http\Middleware\EnsureProfileCompleted::class,
        ]);

        // Apply custom security headers to all web routes
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
