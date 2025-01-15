<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // user_type alias
        $middleware->alias([

            'user_type' => \App\Http\Middleware\CheckUserType::class,
            'commercial.registration' => \App\Http\Middleware\CheckCommercialRegistration::class
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
