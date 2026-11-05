<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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
        RateLimiter::for('login', function (Request $request) {
            $identifier = Str::lower(
                trim((string) $request->input('login'))
            );

            return [
                Limit::perMinute(10)
                    ->by('login-ip:' . $request->ip()),

                Limit::perMinute(5)
                    ->by('login-id:' . sha1($identifier)),
            ];
        });

        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(5)
                ->by('register-ip:' . $request->ip());
        });
    }
}
