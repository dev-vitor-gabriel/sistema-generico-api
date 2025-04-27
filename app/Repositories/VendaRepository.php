<?php

namespace App\Repositories;

use App\Interfaces\VendaRepositoryInterface;
use App\Models\RelVendaMaterial;

class VendaRepository implements VendaRepositoryInterface
{
    public function getTotalMateriaisPorVenda($centros_custo,string $data_inicio,string $data_fim)
    {
        $result = RelVendaMaterial::getTotalMateriaisPorVenda($centros_custo,$data_inicio,$data_fim);

        return $result;
    }
}
