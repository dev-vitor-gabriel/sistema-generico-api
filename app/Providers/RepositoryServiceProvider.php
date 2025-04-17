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
use App\Interfaces\InstituicaoPagamentoRepositoryInterface;
use App\Repositories\InstituicaoPagamentoRepository;
use App\Interfaces\MaterialRepositoryInterface;
use App\Repositories\MaterialRepository;
use App\Interfaces\MetodoPagamentoRepositoryInterface;
use App\Repositories\MetodoPagamentoRepository;
use App\Interfaces\PessoaRepositoryInterface;
use App\Repositories\PessoaRepository;
use App\Interfaces\ServicoTipoRepositoryInterface;
use App\Repositories\ServicoTipoRepository;
use App\Interfaces\UnidadeRepositoryInterface;
use App\Repositories\UnidadeRepository;


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
        $this->app->bind(InstituicaoPagamentoRepositoryInterface::class, InstituicaoPagamentoRepository::class);
        $this->app->bind(MaterialRepositoryInterface::class, MaterialRepository::class);
        $this->app->bind(MetodoPagamentoRepositoryInterface::class, MetodoPagamentoRepository::class);
        $this->app->bind(PessoaRepositoryInterface::class, PessoaRepository::class);
        $this->app->bind(ServicoTipoRepositoryInterface::class, ServicoTipoRepository::class);
        $this->app->bind(UnidadeRepositoryInterface::class, UnidadeRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
