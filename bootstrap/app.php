<?php

use App\Support\InfrastructureFailure;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\TrackVisits::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (PostTooLargeException $e, $request) {
            $message = 'The upload is too large. Use images up to 6 MB each, or upload fewer gallery images at once.';

            if ($request->is('admin/*')) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', $message);
            }

            return response($message, 413);
        });

        $exceptions->renderable(function (\Throwable $e, $request) {
            if (! InfrastructureFailure::recognizes($e)) {
                return null;
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The service is temporarily unavailable. Please try again shortly.',
                ], 503);
            }

            return response()
                ->view('errors.infrastructure', [], 503)
                ->header('Retry-After', '60');
        });
    })->create();
