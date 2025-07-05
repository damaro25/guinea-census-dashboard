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
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Illuminate\Routing\Exceptions\InvalidSignatureException $e, \Illuminate\Http\Request $request) {
            return response()->view('chimera::error.link-invalid', [], 403);
        });
        $exceptions->render(function (Throwable $e, \Illuminate\Http\Request $request) {
            if ($e->getPrevious() instanceof \Illuminate\Session\TokenMismatchException) {
                app('redirect')->setIntendedUrl(url()->previous());
                return redirect()->route('login')
                    ->withInput(request()->except('_token'))
                    ->withErrors('Security token has expired. Please sign-in again.');
            }
        });

        //
    })->create();
