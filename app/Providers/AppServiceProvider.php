<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('components.pagination');

        RateLimiter::for('contact', function (Request $request) {
            return [
                Limit::perMinutes(15, 4)->by($request->ip()),
                Limit::perHour(10)->by($request->ip()),
            ];
        });
    }
}
