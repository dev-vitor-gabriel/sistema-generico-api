<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ServicoTipo;
use Illuminate\Http\Request;

class ServicoTipoController extends Controller
{
    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_servico_tipo_stp' => 'required|string|max:255',
            'vlr_servico_tipo_stp' => 'required|string|max:255',
        ]);

        $servico_tipo = ServicoTipo::create([
            'des_servico_tipo_stp' => $request->des_servico_tipo_stp,
            'vlr_servico_tipo_stp' => $request->vlr_servico_tipo_stp,
            'is_ativo_stp'         => 1,
            'id_empresa_stp'       => $id_empresa,
        ]);

        return response()->json($servico_tipo,201);
    }

    public function get(Request $request, Int $id_servico_tipo = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_servico_tipo){
            $data = ServicoTipo::getById($id_empresa, $id_servico_tipo);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Tip de Serviço Não Existe',],400);
            }
            return $data;
        }
        $data = ServicoTipo::getAll($id_empresa);
        return $data;
    }

    public function update(Int $id_servico_tipo, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_servico_tipo_stp' => 'required|string|max:255',
            'vlr_servico_tipo_stp' => 'required|string|max:255',
        ]);

        ServicoTipo::updateReg($id_empresa, $id_servico_tipo, $request);
    }

    // delete (inactivate)
    public function delete(Int $id_servico_tipo, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);
        ServicoTipo::deleteReg($id_empresa, $id_servico_tipo);
    }
}

