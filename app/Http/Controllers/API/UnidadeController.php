<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    public function create(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_unidade_und'       => 'required|string|max:255',
            'des_reduz_unidade_und' => 'required|string|max:255',
            'id_centro_custo_und'   => 'required|integer|',
        ]);

        $servico_tipo = Unidade::create([
            'des_unidade_und'       => $request->des_unidade_und,
            'des_reduz_unidade_und' => $request->des_reduz_unidade_und,
            'id_centro_custo_und'   => $request->id_centro_custo_und,
            'is_ativo_stp'          => 1,
            'id_empresa'            => $id_empresa,
        ]);

        return response()->json($servico_tipo,201);
    }

    public function get(Request $request, Int $id_unidade_und = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_unidade_und){
            $data = Unidade::getById(($id_unidade_und));
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Unidade Não Existe',],400);
            }
            return $data;
        }
        $data = Unidade::getAll($id_empresa);
        return $data;
    }

    public function update(Int $id_unidade_und, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_unidade_und'       => 'string|max:255',
            'des_reduz_unidade_und' => 'string|max:255',
            'id_centro_custo_und'   => 'integer',
        ]);
        Unidade::updateReg($id_empresa, $id_unidade_und, $request);
    }

    public function delete(Int $id_unidade_und, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        Unidade::deleteReg($id_empresa, $id_unidade_und);
    }

}
