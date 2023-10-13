<?php

namespace App\Http\Controllers\api;
use App\Models\MaterialMovimentacao;
use App\Models\Material;
use App\Models\MaterialMovimentacaoItem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialMovimentacaoController extends Controller
{
    public function create(Request $request, $tipo_movimentacao) {

        $request->validate([
            'id_estoque'             => 'required|int',
            'id_centro_custo_mov'    => 'required|int'
        ]);

        $materialMov = MaterialMovimentacao::create([
            'txt_movimentacao_mov'   => $request->txt_movimentacao_mov,
            'id_estoque_entrada_mov' => $tipo_movimentacao == 'entrada' ? $request->id_estoque : null,
            'id_estoque_saida_mov'   => $tipo_movimentacao == 'saida'   ? $request->id_estoque : null,
            'id_centro_custo_mov'    => $request->id_centro_custo_mov,
            'is_ativo_mov'           => 1,
        ]);

        foreach ($request->materiais as $material) {
            if (isset($material['vlr_material_mit'])) {
                $value = $material['vlr_material_mit'];
            } else {
                $value = Material::select(['vlr_material_mte'])->where('id_material_mte', $material['id_material_mte'])->get()[0]->vlr_material_mte;
            }

            MaterialMovimentacaoItem::create([
                'id_movimentacao_mit'                   => $materialMov->id,
                'id_material_mit'                       => $material['id_material_mte'],
                'qtd_material_mit'                      => $material['qtd_material_mit'],
                'vlr_material_mit'                      => $value
            ]);
        }

        return response()->json($materialMov,201);
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
