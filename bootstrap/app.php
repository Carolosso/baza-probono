<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\TwoFactorMiddleware;
use App\Http\Middleware\CheckIfAdmin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
     $middleware->alias([
        '2fa' => \App\Http\Middleware\TwoFactorMiddleware::class,
        'checkIfAdmin' => \App\Http\Middleware\CheckIfAdmin::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
