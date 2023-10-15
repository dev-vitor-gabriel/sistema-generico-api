<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function create(Request $request) {

        $request->validate([
            'des_cliente_cli'      => 'required|string|max:255',
            'telefone_cliente_cli' => 'required|string|max:11',
            'email_cliente_cli'    => 'required|string|max:11',
            'documento_cliente_cli'=> 'string|max:11',
            'endereco_cliente_cli' => 'string|max:255',
        ]); 

        $cliente = Cliente::create([
            'des_cliente_cli'       => $request->des_cliente_cli,
            'telefone_cliente_cli'  => $request->telefone_cliente_cli,
            'email_cliente_cli'     => $request->email_cliente_cli,
            'documento_cliente_cli' => $request->documento_cliente_cli,
            'endereco_cliente_cli'  => $request->endereco_cliente_cli,
            'is_ativo_cli' => 1,
        ]);

        return response()->json($cliente,201);
    }

    public function get(Int $id_cliente = null) {
        if($id_cliente){
            $data = Cliente::getById(($id_cliente));
            return $data;
        }
        $data = Cliente::getAll();
        return $data;
    }

    public function update(Int $id_cliente, Request $request) {
        $request->validate([
            'des_cliente_cli'      => 'required|string|max:255',
            'telefone_cliente_cli' => 'required|string|max:11',
            'email_cliente_cli'    => 'required|string|max:11',
            'documento_cliente_cli'=> 'string|max:11',
            'endereco_cliente_cli' => 'string|max:255',
        ]);
        Cliente::updateReg($id_cliente, $request);
    }

    // delete (inactivate)
    public function delete(Int $id_cliente) {
        Cliente::deleteReg($id_cliente);
    }
}
