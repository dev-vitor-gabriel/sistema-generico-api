<?php

namespace App\Http\Controllers\api;
use App\Models\MaterialMovimentacao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialMovimentacaoController extends Controller
{
    public function create(Request $request) {

        $request->validate([
            'txt_movimentacao_mov' => 'required|string',
            'id_estoque_entrada_mov' => 'required|int',
            'id_estoque_saida_mov' => 'required|int'
        ]); 

        $material = MaterialMovimentacao::create([
            'txt_movimentacao_mov' => $request->txt_movimentacao_mov,
            'id_estoque_entrada_mov' => $request->id_estoque_entrada_mov,
            'id_estoque_saida_mov' => $request->id_estoque_saida_mov,
            'is_ativo_mov' => 1,
        ]);

        return response()->json($material,201);
    }

    public function get(Int $id_movimentacao = null) {

        $data = MaterialMovimentacao::get($id_movimentacao);
        return $data;
    }

    public function update(Int $id_movimentacao, Request $request) {
        
        $request->validate([
            'txt_movimentacao_mov' => 'required|string'
        ]);
        MaterialMovimentacao::updateReg($id_movimentacao, $request);
    }

    // delete (inactivate)
    public function delete(Int $id_movimentacao) {
        MaterialMovimentacao::deleteReg($id_movimentacao);
    }
}
