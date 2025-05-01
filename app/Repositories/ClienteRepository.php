<?php

namespace App\Repositories;

use App\Interfaces\ClienteRepositoryInterface;
use App\Models\Cliente;

class ClienteRepository implements ClienteRepositoryInterface
{
    public function create($request, $id_empresa)
    {
        $result = Cliente::create(array_merge(
            $request,
            ['id_empresa_cli' => $id_empresa]
        ));

        return $result;
    }

    public function getAll($id_empresa, $filter, $per_page, $page_number)
    {
        $result = Cliente::getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    public function getById($id_cliente, $id_empresa)
    {
        $result = Cliente::getById($id_cliente, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_cliente, $dados_atualizados)
    {
        $result = Cliente::updateReg($id_empresa, $id_cliente, $dados_atualizados);

        return $result;
    }

    public function deleteReg($id_empresa, $id_cliente)
    {
        $result = Cliente::deleteReg($id_empresa, $id_cliente);

        return $result;
    }
}