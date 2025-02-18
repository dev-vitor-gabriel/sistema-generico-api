<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CentroCusto;
use Illuminate\Http\Request;

class CentroCustoController extends Controller
{
    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }
    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_centro_custo_cco' => 'required|string|max:255'
        ]);

        $cliente = CentroCusto::create([
            'des_centro_custo_cco' => $request->des_centro_custo_cco,
            'id_empresa_cco' => $id_empresa,
        ]);

        return response()->json($cliente,201);
    }

    public function get(Request $request, Int $id_centro_custo = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_centro_custo){
            $data = CentroCusto::getById($id_empresa, $id_centro_custo);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Centro de Custo Não Existe',],400);
            }
            return $data;
        }
        $data = CentroCusto::getAll($id_empresa);
        return $data;
    }

    public function update(Int $id_centro_custo, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_centro_custo_cco' => 'required|string|max:255'
        ]);
        CentroCusto::updateReg($id_empresa, $id_centro_custo, $request);
    }

    public function delete(Int $id_centro_custo, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);
        CentroCusto::deleteReg($id_empresa, $id_centro_custo);
    }
}
