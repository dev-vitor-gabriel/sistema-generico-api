<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use Illuminate\Http\Request;


class FuncionarioController extends Controller
{
    public function create(Request $request) {

        $request->validate([
            'id_funcionario_cargo_tfu' => 'required|int|max:255',
            'desc_funcionario_tfu' => 'required|string|max:255',
            'documento_funcionario_tfu' => 'required|string|max:255',
            'telefone_funcionario_tfu' => 'required|string|max:255',
            'endereco_funcionario_tfu' => 'required|string|max:255'
        ]); 

        $funcionario = Funcionario::create([
            'id_funcionario_cargo_tfu' => $request->id_funcionario_cargo_tfu,
            'desc_funcionario_tfu' => $request->desc_funcionario_tfu,
            'documento_funcionario_tfu' => $request->documento_funcionario_tfu,
            'telefone_funcionario_tfu' => $request->telefone_funcionario_tfu,
            'endereco_funcionario_tfu' => $request->endereco_funcionario_tfu
        ]);

        return response()->json($funcionario,201);
    }

    public function get(Int $id_funcionario = null) {
        if($id_funcionario){
            $data = Funcionario::getById(($id_funcionario));
            return $data;
        }
        $data = Funcionario::getAll();
        return $data;
    }

    public function update(Int $id_funcionario, Request $request) {
        $request->validate([
            'id_funcionario_cargo_tfu' => 'required|int|max:255',
            'desc_funcionario_tfu' => 'required|string|max:255',
            'documento_funcionario_tfu' => 'required|string|max:255',
            'telefone_funcionario_tfu' => 'required|string|max:255',
            'endereco_funcionario_tfu' => 'required|string|max:255'
        ]);
        Funcionario::updateReg($id_funcionario, $request);
    }

    public function delete(Int $id_funcionario) {
        Funcionario::deleteReg($id_funcionario);
    }
}
