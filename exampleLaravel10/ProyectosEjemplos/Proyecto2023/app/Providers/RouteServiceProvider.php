<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {

        /**
         * expresion regular para cubrir la seguridad del id
         */
        Route::pattern('id', '[0-9]+');
        Route::pattern('idc', '[0-9]+');

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware(['web','auth'])
                ->prefix('casos')
                ->group(base_path('routes/casos.php'));

            Route::middleware(['web','auth'])
                ->prefix('resoluciones')
                ->group(base_path('routes/resoluciones.php'));

            Route::middleware(['web','auth'])
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware(['web'])
                ->prefix('denuncias')
                ->group(base_path('routes/denuncias.php'));

            Route::middleware(['web','auth'])
                ->prefix('auditorias')
                ->group(base_path('routes/auditorias.php'));

            Route::middleware(['web','auth'])
                ->prefix('planeaciones')
                ->group(base_path('routes/planeaciones.php'));

            Route::middleware(['web','auth'])
                ->prefix('archivos')
                ->group(base_path('routes/archivos.php'));
        });
    }
}
