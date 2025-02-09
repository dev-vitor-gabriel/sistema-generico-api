<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Helpers\ValidateString;
use Illuminate\Support\Facades\Validator;


class ClienteController extends Controller
{
    public function create(Request $request) {
        $id_empresa = $request->header('id_empresa');
    
        $document_formated = ValidateString::removeCharacterSpecial($request->documento_cliente_cli);
        $request->merge(['documento_cliente_cli' => $document_formated]);
        $validator = Validator::make($request->all(), [
            'des_cliente_cli'       => 'required|string|max:255',
            'telefone_cliente_cli'  => 'required|string|max:11',
            'email_cliente_cli'     => 'required|string|max:255',
            'documento_cliente_cli' => 'string|max:11',
            'endereco_cliente_cli'  => 'string|max:255',
            'id_centro_custo_cli'   => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cliente = Cliente::create([
            'des_cliente_cli'       => $request->des_cliente_cli,
            'telefone_cliente_cli'  => $request->telefone_cliente_cli,
            'email_cliente_cli'     => $request->email_cliente_cli,
            'documento_cliente_cli' => $request->documento_cliente_cli,
            'endereco_cliente_cli'  => $request->endereco_cliente_cli,
            'id_centro_custo_cli'   => $request->id_centro_custo_cli,
            'id_empresa'            => $id_empresa,
            'is_ativo_cli'          => 1,
        ]);
        

        return response()->json($cliente,201);
    }

    public function get(Request $request, Int $id_cliente = null) {
        $id_empresa = $request->header('id_empresa');

        if($id_cliente){
            $data = Cliente::getById($id_empresa, $id_cliente);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Cliente Não Existe',],400);
            }
            return $data;
        }
        $data = Cliente::getAll($id_empresa);
        return $data;
    }

    public function update(Int $id_cliente, Request $request) {
        $id_empresa = $request->header('id_empresa');

        $document_formated = ValidateString::removeCharacterSpecial($request->documento_cliente_cli);
        $request->merge(['documento_cliente_cli' => $document_formated]);
        $validator = Validator::make($request->all(),[
            'des_cliente_cli'       => 'required|string|max:255',
            'telefone_cliente_cli'  => 'required|string|max:11',
            'email_cliente_cli'     => 'required|string|max:255',
            'documento_cliente_cli' => 'string|max:11',
            'endereco_cliente_cli'  => 'string|max:255',
            'id_centro_custo_cli'   => 'integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        Cliente::updateReg($id_empresa, $id_cliente, $request);
        
    }

    // delete (inactivate)
    public function delete(Int $id_cliente, Request $request) {
        $id_empresa = $request->header('id_empresa');

        Cliente::deleteReg($id_empresa, $id_cliente);
    }
}
