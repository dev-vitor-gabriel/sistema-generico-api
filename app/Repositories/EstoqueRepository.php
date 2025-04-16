<?php

namespace App\Repositories;

use App\Interfaces\EstoqueRepositoryInterface;
use App\Models\Estoque;

class EstoqueRepository implements EstoqueRepositoryInterface
{
    public function create($request, $id_empresa)
    {
        $result = estoque::create($request,$id_empresa);

        return $result;
    }

    public function getAll($id_empresa, $filter, $per_page, $page_number)
    {
        $result = estoque::getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    public function getById($id_estoque, $id_empresa)
    {
        $result = estoque::getById($id_estoque, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_estoque, $request)
    {
        $result = estoque::updateReg($id_empresa, $id_estoque, $request);

        return $result;
    }

    public function deleteReg($id_empresa, $id_estoque)
    {
        $result = estoque::deleteReg($id_empresa, $id_estoque);

        return $result;
    }
}