<?php

namespace App\Interfaces;

interface InstituicaoPagamentoRepositoryInterface
{
    public function create($request, $id_empresa);
    public function getAll($id_empresa, $filter, $per_page, $page_number);
    public function getById($id_empresa, $id_instituicao_pagamento);
    public function updateReg($id_empresa, $id_instituicao_pagamento, $dados_atualizados);
    public function deleteReg($id_empresa, $id_instituicao_pagamento);
}