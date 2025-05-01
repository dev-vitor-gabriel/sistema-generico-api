<?php

namespace App\Interfaces;

interface MaterialRepositoryInterface
{
    public function create($request);
    public function getAll($id_empresa, $filter, $per_page, $page_number, $verificar_estoque);
    public function getById($id_empresa, $id_material);
    public function updateReg($id_empresa, $id_material, $request);
    public function deleteReg($id_empresa, $id_material);
}
