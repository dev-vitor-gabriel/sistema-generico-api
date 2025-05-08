<?php

namespace App\Repositories;

use App\Interfaces\FinanceiroRepositoryInterface;
use App\Models\Financeiro;

class FinanceiroRepository implements FinanceiroRepositoryInterface
{
    public function create($request)
    {
        $result = Financeiro::create($request);

        return $result;
    }
}