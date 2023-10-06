<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use APP\Models\MetodoPagamento;
use Illuminate\Http\Request;

class MetodoPagamentoController extends Controller
{
    public function create(Request $request) {

        $request->validate([
            'desc_metodo_pagamento_tmp'       => 'required|string|max:255'
        ]);

        $metodoPagamento = MetodoPagamento::create([
            'desc_metodo_pagamento_tmp'       => $request->desc_metodo_pagamento_tmp,
            'is_ativo_tmp'                    => 1
        ]);

        return response()->json($metodoPagamento,201);
    }

    public function get(Int $id_metodo_pagamento = null) {
        if($id_metodo_pagamento){
            $data = MetodoPagamento::getById(($id_metodo_pagamento));
            return $data;
        }
        $data = MetodoPagamento::getAll();
        return $data;
    }

    public function update(Int $id_metodo_pagamento, Request $request) {
        $request->validate([
            'desc_metodo_pagamento_tmp'       => 'string|max:255'
        ]);
        MetodoPagamento::updateReg($id_metodo_pagamento, $request);
    }

    public function delete(Int $id_metodo_pagamento) {
        MetodoPagamento::deleteReg($id_metodo_pagamento);
    }
}
