<?php

namespace App\Interfaces;

interface MaterialRepositoryInterface
{
    public function create($request, $id_empresa);
    public function getAll($id_empresa, $filter, $per_page, $page_number);
    public function getById($id_empresa, $material);
    public function updateReg($id_empresa, $material, $request);
    public function deleteReg($id_empresa, $material);
}