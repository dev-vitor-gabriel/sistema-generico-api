<?php

namespace App\Interfaces;

interface EstoqueRepositoryInterface
{
    public function create($request, $id_empresa);
    public function getAll($id_empresa, $filter, $per_page, $page_number, $id_centro_custo);
    public function getById($id_empresa, $id_estoque);
    public function updateReg($id_empresa, $id_estoque, $request);
    public function deleteReg($id_empresa, $id_estoque);
}
