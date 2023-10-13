<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ServicoTipo;
use Illuminate\Http\Request;

class ServicoTipoController extends Controller
{
    public function create(Request $request) {

        $request->validate([
            'des_servico_tipo_stp' => 'required|string|max:255',
            'vlr_servico_tipo_stp' => 'required|string|max:255',
        ]);

        $servico_tipo = ServicoTipo::create([
            'des_servico_tipo_stp' => $request->des_servico_tipo_stp,
            'vlr_servico_tipo_stp' => $request->vlr_servico_tipo_stp,
            'is_ativo_stp' => 1,
        ]);

        return response()->json($servico_tipo,201);
    }

    public function get(Int $id_servico_tipo = null) {
        if($id_servico_tipo){
            $data = ServicoTipo::getById(($id_servico_tipo));
            return $data;
        }
        $data = ServicoTipo::getAll();
        return $data;
    }

    public function update(Int $id_servico_tipo, Request $request) {
        $request->validate([
            'des_servico_tipo_stp' => 'required|string|max:255',
            'vlr_servico_tipo_stp' => 'required|string|max:255',
        ]);
        ServicoTipo::updateReg($id_servico_tipo, $request);
    }

    // delete (inactivate)
    public function delete(Int $id_servico_tipo) {
        ServicoTipo::deleteReg($id_servico_tipo);
    }
}

