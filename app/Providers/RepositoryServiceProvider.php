<?php

namespace App\Providers;

use App\Interfaces\CargoRepositoryInterface;
use App\Repositories\CargoRepository;
use App\Interfaces\CentroCustoRepositoryInterface;
use App\Repositories\CentroCustoRepository;
use App\Interfaces\ClienteRepositoryInterface;
use App\Repositories\ClienteRepository;
use App\Interfaces\EstoqueRepositoryInterface;
use App\Repositories\EstoqueRepository;
use App\Interfaces\FornecedorRepositoryInterface;
use App\Repositories\FornecedorRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CargoRepositoryInterface::class, CargoRepository::class);
        $this->app->bind(CentroCustoRepositoryInterface::class, CentroCustoRepository::class);
        $this->app->bind(ClienteRepositoryInterface::class, ClienteRepository::class);
        $this->app->bind(EstoqueRepositoryInterface::class, EstoqueRepository::class);
        $this->app->bind(FornecedorRepositoryInterface::class, FornecedorRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
