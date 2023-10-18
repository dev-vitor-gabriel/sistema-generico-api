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

        // get
        public function get(Int $id_material = null)
        {

            $data = MaterialMovimentacao::get($id_material);

            $input_array = $data->toArray();

            $data = $this->groupMovimentacaoMaterialByMovimentacaoMaterialItem($input_array);
            // return $data;
            return response()->json($data);
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

    private function groupMovimentacaoMaterialByMovimentacaoMaterialItem($input_array){
        // variavel de saida
        $output_array = [];

        // agrupa materiais
        foreach ($input_array as $item) {
            $id = $item['id_movimentacao_mov'];
            if (!isset($output_array[$id])) {
                $output_array[$id] = [...$item,
                    'materiais' => [],
                ];
                unset($output_array[$id]['id_material_mte']);
                unset($output_array[$id]['des_material_mte']);
                unset($output_array[$id]['vlr_material_mte']);
                unset($output_array[$id]['des_reduz_unidade_und']);
                unset($output_array[$id]['id_material_mit']);
                unset($output_array[$id]['vlr_material_mit']);
                unset($output_array[$id]['qtd_material_mit']);
            }

            if ($item['id_material_mte'] !== null) {
                $temp = array_filter($output_array[$id]['materiais'], function ($reg) use($item) { return $reg['id_material_mte'] == $item['id_material_mte']; });
                if(count($temp) == 0) {
                    $output_array[$id]['materiais'][] = [
                        "id_material_mte"  => $item['id_material_mte'],
                        "des_material_mte" => $item['des_material_mte'],
                        "vlr_material_mit" => $item['vlr_material_mit'],
                        "qtd_material_mit" => $item['qtd_material_mit']
                    ];
                }
            }
        }

        // Converte o array associativo em um array indexado
        $output_array = array_values($output_array);
        return $output_array;
    }
}
