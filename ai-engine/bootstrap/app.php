<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Tambahkan baris ini untuk mengatur redirect setelah login
        $middleware->redirectTo(
            guests: '/login',
            users: '/', // Mengarahkan user ke landing page setelah login
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();