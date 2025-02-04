<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function create(Request $request)
    {
        $id_empresa = $request->header('id_empresa');

        $request->validate([
            'des_unidade_und'       => 'required|string|max:255',
            'des_reduz_unidade_und' => 'required|string|max:255',
        ]);

        $servico_tipo = Unidade::create([
            'des_unidade_und'       => $request->des_unidade_und,
            'des_reduz_unidade_und' => $request->des_reduz_unidade_und,
            'is_ativo_stp'          => 1,
            'id_empresa'            => $id_empresa,
        ]);

        return response()->json($servico_tipo,201);
    }

    public function get(Request $request, Int $id_unidade_und = null) {
        $id_empresa = $request->header('id_empresa');
        if($id_unidade_und){
            $data = Unidade::getById(($id_unidade_und));
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Unidade Não Existe',],400);
            }
            return $data;
        }
        $data = Unidade::getAll();
        return $data;
    }

    public function update(Int $id_unidade_und, Request $request) {
        $id_empresa = $request->header('id_empresa');
        $request->validate([
            'des_unidade_und'       => 'string|max:255',
            'des_reduz_unidade_und' => 'string|max:255',
        ]);
        Unidade::updateReg($id_empresa, $id_unidade_und, $request);
    }

    public function delete(Int $id_unidade_und, Request $request) {
        $id_empresa = $request->header('id_empresa');

        Unidade::deleteReg($id_empresa, $id_unidade_und);
    }

}
