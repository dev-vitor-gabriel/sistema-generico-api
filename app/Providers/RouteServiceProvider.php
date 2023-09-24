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
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

            Route::middleware('web')
            ->group(base_path('routes/web.php'));

            Route::middleware('api')
            ->prefix('api/auth')
            ->group(base_path('routes/api/auth.php'));

            Route::middleware('api')
            ->prefix('api/servico')
            ->group(base_path('routes/api/servico.php'));

            Route::middleware('api')
            ->prefix('api/servicoTipo')
            ->group(base_path('routes/api/servicoTipo.php'));

            Route::middleware('api')
            ->prefix('api/material')
            ->group(base_path('routes/api/material.php'));

            Route::middleware('api')
            ->prefix('api/estoque')
            ->group(base_path('routes/api/estoque.php'));

            Route::middleware('api')
            ->prefix('api/movimentacao')
            ->group(base_path('routes/api/materialMovimentacao.php'));

            Route::middleware('api')
            ->prefix('api/cliente')
            ->group(base_path('routes/api/cliente.php'));

            Route::middleware('api')->prefix('api/centroCusto')
            ->group(base_path('routes/api/centroCusto.php'));

            Route::middleware('api')->prefix('api/unidade')
            ->group(base_path('routes/api/unidade.php'));
        });
    }
}
