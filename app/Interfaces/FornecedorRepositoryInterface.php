<?php

namespace App\Interfaces;

interface FornecedorRepositoryInterface
{
    public function create($request, $id_empresa);
    public function getAll($id_empresa, $filter, $per_page, $page_number);
    public function getById($id_empresa, $fornecedor);
    public function updateReg($id_empresa, $fornecedor, $request);
    public function deleteReg($id_empresa, $fornecedor);
}