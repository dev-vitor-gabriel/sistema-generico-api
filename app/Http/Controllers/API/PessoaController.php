<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use App\Helpers\ValidateString;

class PessoaController extends Controller
{
    public function create(request $request){

        $request->validate([
            'nome_pessoa_pes'           => 'required|string|',
            'id_centro_custo_pes'       => 'required|integer|',
            'documento_pessoa_pes'      => 'string|',
        ]);

        $pessoa = Pessoa::create([
            'nome_pessoa_pes'           => $request->nome_pessoa_pes,
            'id_centro_custo_pes'       => $request->id_centro_custo_pes,
            'documento_pessoa_pes'      => ValidateString::removeCharacterSpecial($request->documento_pessoa_pes)
        ]);
        return response()->json($pessoa,201);
    }

    public function get(Int $id_pessoa = null){

        if($id_pessoa){
            $data = Pessoa::getById($id_pessoa);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'erro'=> 'Pessoa Não Existe'
                ],400);
            }
            return $data;
        }
        $data = Pessoa::getAll();
        return $data;
    }

    public function update(Int $id_pessoa, request $request){
        $request->validate([
            'nome_pessoa_pes'           => 'string',
            'id_centro_custo_pes'       => 'integer',
            'documento_pessoa_pes'      => 'string',
        ]);
        Pessoa::updateReg($id_pessoa, $request);
    }

    //delete (inactivate)
    public function delete(Int $id_pessoa){
        Pessoa::deleteReg($id_pessoa);
    }
}
