<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MetodoPagamento;
use Illuminate\Http\Request;

class MetodoPagamentoController extends Controller
{
    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'desc_metodo_pagamento_tmp'       => 'required|string|max:255'
        ]);

        $metodoPagamento = MetodoPagamento::create([
            'desc_metodo_pagamento_tmp'       => $request->desc_metodo_pagamento_tmp,
            'is_ativo_tmp'                    => 1,
            'id_empresa_tmp' => $id_empresa,
        ]);

        return response()->json($metodoPagamento,201);
    }

    public function get(Request $request, Int $id_metodo_pagamento = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_metodo_pagamento){
            $data = MetodoPagamento::getById($id_empresa, $id_metodo_pagamento);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Metodo de Pagamento Não Existe',],400);
            }
            return $data;
        }
        $data = MetodoPagamento::getAll($id_empresa);
        return $data;
    }

    public function update(Int $id_metodo_pagamento, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'desc_metodo_pagamento_tmp'       => 'string|max:255'
        ]);
        MetodoPagamento::updateReg($id_empresa, $id_metodo_pagamento, $request);
    }

    public function delete(Int $id_metodo_pagamento, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);
        MetodoPagamento::deleteReg($id_empresa, $id_metodo_pagamento);
    }
}
