<?php

namespace App\Interfaces;

interface EstoqueRepositoryInterface
{
    public function create($request, $id_empresa);
    public function getAll($id_empresa, $filter, $per_page, $page_number);
    public function getById($id_empresa, $id_estoque);
    public function updateReg($id_empresa, $id_estoque, $dados_atualizados);
    public function deleteReg($id_empresa, $id_estoque);
}