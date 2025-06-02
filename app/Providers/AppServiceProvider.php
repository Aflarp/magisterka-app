<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
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
    public function boot()
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(1)->by($request->ip()); // Możesz też użyć $request->user()?->id()
        });
        if (env('APP_ENV') === 'production') {
            \URL::forceScheme('https');
        }
    }

}
