<?php

namespace App\Interfaces;

interface ClienteRepositoryInterface
{
    public function create($request, $id_empresa);
    public function getAll($id_empresa, $filter, $per_page, $page_number);
    public function getById($id_empresa, $id_cliente);
    public function updateReg($id_empresa, $id_cliente, $request);
    public function deleteReg($id_empresa, $id_cliente);
}