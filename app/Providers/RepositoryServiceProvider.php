<?php

namespace App\Providers;

use App\Interfaces\CargoRepositoryInterface;
use App\Repositories\CargoRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CargoRepositoryInterface::class, CargoRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
