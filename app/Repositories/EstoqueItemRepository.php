<?php

namespace App\Repositories;

use App\Interfaces\EstoqueItemRepositoryInterface;
use App\Models\EstoqueItem;

class EstoqueItemRepository implements EstoqueItemRepositoryInterface
{
    public function create($request, $id_empresa)
    {
        $result = EstoqueItem::create($request,$id_empresa);

        return $result;
    }

    public function getAll($id_empresa, $filter, $per_page, $page_number)
    {
        $result = EstoqueItem::getAll($id_empresa, $filter, $per_page, $page_number);
        return $result;
    }

    public function getById($id_estoque_item, $id_empresa)
    {
        $result = EstoqueItem::getById($id_estoque_item, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_estoque_item, $request)
    {
        $result = EstoqueItem::updateReg($id_empresa, $id_estoque_item, $request);

        return $result;
    }

    public function deleteReg($id_empresa, $id_estoque_item)
    {
        $result = EstoqueItem::deleteReg($id_empresa, $id_estoque_item);

        return $result;
    }

    public function getByCentroCustoMaterial($id_centro_custo_eti, $id_material_eti)
    {
        $result = EstoqueItem::getByCentroCustoMaterial($id_centro_custo_eti, $id_material_eti);

        return $result;
    }

}
