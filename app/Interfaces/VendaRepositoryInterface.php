<?php

namespace App\Interfaces;

interface VendaRepositoryInterface
{
    public function getTotalMateriaisPorVenda($centros_custo,string $data_inicio,string $data_fim);
    public function getValorMateriaisPorVenda($centros_custo,string $data_inicio,string $data_fim);
}