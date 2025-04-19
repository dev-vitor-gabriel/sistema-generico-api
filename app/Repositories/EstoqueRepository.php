<?php

namespace App\Repositories;

use App\Interfaces\EstoqueRepositoryInterface;
use App\Models\Estoque;

class EstoqueRepository implements EstoqueRepositoryInterface
{
    public function create($request, $id_empresa)
    {
        $result = Estoque::create($request,$id_empresa);

        return $result;
    }

    public function getAll($id_empresa, $filter, $per_page, $page_number)
    {
        $result = Estoque::getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    public function getById($id_estoque, $id_empresa)
    {
        $result = Estoque::getById($id_estoque, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_estoque, $dados_atualizados)
    {
        $result = Estoque::updateReg($id_empresa, $id_estoque, $dados_atualizados);

        return $result;
    }

    public function deleteReg($id_empresa, $id_estoque)
    {
        $result = Estoque::deleteReg($id_empresa, $id_estoque);

        return $result;
    }
}