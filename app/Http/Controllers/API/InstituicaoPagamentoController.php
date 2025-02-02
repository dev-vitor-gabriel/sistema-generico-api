<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\InstituicaoPagamento;
use Illuminate\Http\Request;

class InstituicaoPagamentoController extends Controller
{
    public function create(Request $request) {
        $id_empresa = $request->header('id_empresa');

        $request->validate([
            'desc_instituicao_pagamento_tip'       => 'required|string|max:255'
        ]);

        $instituicaoPagamento = InstituicaoPagamento::create([
            'desc_instituicao_pagamento_tip'       => $request->desc_instituicao_pagamento_tip,
            'is_ativo_tip'                         => 1,
            'id_empresa'                           => $id_empresa,
        ]);

        return response()->json($instituicaoPagamento,201);
    }

    public function get(Int $id_instituicao_pagamento = null) {
        if($id_instituicao_pagamento){
            $data = InstituicaoPagamento::getById(($id_instituicao_pagamento));
            $data_array = json_decode($data->content());
           
            if(empty($data_array)){
                return response()->json([
                    'error' => 'Instituicao de Pagamento Não Existe',],400);
            }
            return $data;
        }
        $data = InstituicaoPagamento::getAll();
        return $data;
    }

    public function update(Int $id_instituicao_pagamento, Request $request) {
        $request->validate([
            'desc_instituicao_pagamento_tip'       => 'string|max:255'
        ]);
        InstituicaoPagamento::updateReg($id_instituicao_pagamento, $request);
    }

    public function delete(Int $id_instituicao_pagamento) {
        InstituicaoPagamento::deleteReg($id_instituicao_pagamento);
    }
}
