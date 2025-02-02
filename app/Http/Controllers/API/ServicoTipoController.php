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
            'id_centro_custo_stp'  => 'required|integer|',
        ]);

        $servico_tipo = ServicoTipo::create([
            'des_servico_tipo_stp' => $request->des_servico_tipo_stp,
            'vlr_servico_tipo_stp' => $request->vlr_servico_tipo_stp,
            'id_centro_custo_stp'  => $request->id_centro_custo_stp,
            'is_ativo_stp' => 1,
        ]);

        return response()->json($servico_tipo,201);
    }

    public function get(Int $id_servico_tipo = null) {
        if($id_servico_tipo){
            $data = ServicoTipo::getById(($id_servico_tipo));
            $data_array = json_decode($data->content());
           
            if(empty($data_array)){
                return response()->json([
                    'error' => 'Tip de Serviço Não Existe',],400);
            }
            return $data;
        }
        $data = ServicoTipo::getAll();
        return $data;
    }

    public function update(Int $id_servico_tipo, Request $request) {
        $request->validate([
            'des_servico_tipo_stp' => 'required|string|max:255',
            'vlr_servico_tipo_stp' => 'required|string|max:255',
            'id_centro_custo_stp'  => 'integer',
        ]);
        ServicoTipo::updateReg($id_servico_tipo, $request);
    }

    // delete (inactivate)
    public function delete(Int $id_servico_tipo) {
        ServicoTipo::deleteReg($id_servico_tipo);
    }
}

