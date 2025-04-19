<?php

namespace App\Interfaces;

interface CentroCustoRepositoryInterface
{
    public function create($request, $id_empresa);
    public function getAll($id_empresa, $filter, $per_page, $page_number);
    public function getById($id_empresa, $id_centro_custo);
    public function updateReg($id_empresa, $id_centro_custo, $dados_atualizados);
    public function deleteReg($id_empresa, $id_centro_custo);
}