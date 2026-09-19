<?php

use App\Http\Middleware\AddSecurityHeaders;
use App\Http\Middleware\EnforceHttps;
use App\Http\Middleware\RejectSpamSubmissions;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global, so 404s and other routeless responses are covered too. Appended, so they
        // run after the framework's own TrustProxies middleware (configured in
        // config/trustedproxy.php), which the https redirect needs to see the original scheme.
        $middleware->append([EnforceHttps::class, AddSecurityHeaders::class]);
        $middleware->web(append: [RejectSpamSubmissions::class]);

        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
