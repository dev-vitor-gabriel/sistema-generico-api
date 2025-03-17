<?php

namespace App\Http\Controllers\api;
use App\Models\MaterialMovimentacao;
use App\Models\Material;
use App\Models\Estoque;
use App\Models\MaterialMovimentacaoItem;

use App\Http\Controllers\Controller;
use App\Models\EstoqueItem;
use Illuminate\Http\Request;

class MaterialMovimentacaoController extends Controller
{

    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

     /**
     * @OA\Post(
     *     path="/material-movimentacao/{tipo_movimentacao}/create",
     *     summary="Criar movimentação de material",
     *     description="Cria uma movimentação de material de entrada ou saída",
     *     @OA\Parameter(
     *         name="tipo_movimentacao",
     *         in="path",
     *         required=true,
     *         description="Tipo de movimentação (entrada ou saída)"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"txt_movimentacao_mov", "id_estoque", "id_centro_custo_mov", "materiais"},
     *             @OA\Property(property="txt_movimentacao_mov", type="string", description="Descrição da movimentação"),
     *             @OA\Property(property="id_estoque", type="integer", description="ID do estoque"),
     *             @OA\Property(property="id_centro_custo_mov", type="integer", description="ID do centro de custo"),
     *             @OA\Property(property="materiais", type="array", @OA\Items(
     *                 @OA\Property(property="id_material_mte", type="integer", description="ID do material"),
     *                 @OA\Property(property="qtd_material_mit", type="integer", description="Quantidade do material"),
     *                 @OA\Property(property="vlr_material_mit", type="number", format="float", description="Valor do material")
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Movimentação criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/MaterialMovimentacao")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function create(Request $request, $tipo_movimentacao) {
        $id_empresa = $this->getIdEmpresa($request);

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
            'id_empresa_mov'         => $id_empresa,
        ]);

        if($tipo_movimentacao == 'entrada'){
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
                    'vlr_material_mit'                      => $value,
                    'tipo_movimentacao_mit'                 => 'entrada'
                ]);

                $estoque_item = EstoqueItem::get($id_empresa, $materialMov->id_estoque_entrada_mov, $material['id_material_mte'], $request->id_centro_custo_mov);

                if ($estoque_item)
                {
                    $estoque_item->qtd_estoque_item_eti += $material['qtd_material_mit'];
                    EstoqueItem::updateReg($id_empresa, $estoque_item->id_estoque_item_eti, $estoque_item);
                } else {
                    $estoque_item = EstoqueItem::create([
                        'id_material_eti' => $material['id_material_mte'],
                        'id_empresa_eti' => $id_empresa,
                        'id_estoque_eti' => $materialMov->id_estoque_entrada_mov,
                        'id_centro_custo_eti' => $request->id_centro_custo_mov,
                        'qtd_estoque_item_eti' =>  $material['qtd_material_mit'],
                    ]);
                }
            }

            return response()->json($materialMov,201);
        }

        if($tipo_movimentacao == 'saida'){
            $consulta_estoque = Estoque::getEstoqueComValoresById($materialMov->id_estoque_saida_mov);
            $movimentacao_estoque = [];
            foreach ($consulta_estoque as $item) {
                $movimentacao_estoque[$item->material_id] = [
                    'id_estoque'           => $item->estoque_id,
                    'qtd_material_estoque' => $item->quantidade_em_estoque,
                ];
            }

            foreach ($request->materiais as $material) {
                $material_id = $material['id_material_mte'];
                $quantidade_solicitada = $material['qtd_material_mit'];

                // Verifica se o material existe no estoque
                if (!isset($movimentacao_estoque[$material_id])) {
                    return response()->json([
                        'error' => "Material com ID {$material_id} não encontrado no estoque."
                    ], 404);
                }

                if (isset($material['vlr_material_mit'])) {
                    $value = $material['vlr_material_mit'];
                } else {
                    $value = Material::select(['vlr_material_mte'])->where('id_material_mte', $material['id_material_mte'])->get()[0]->vlr_material_mte;
                }

                $quantidade_disponivel = $movimentacao_estoque[$material_id]['qtd_material_estoque'];
                if ($quantidade_solicitada > $quantidade_disponivel) {
                    return response()->json([
                        'error' => "Quantidade insuficiente no estoque para o material com ID {$material_id}. Disponível: {$quantidade_disponivel}, Solicitado: {$quantidade_solicitada}."
                    ], 400);
                }

                MaterialMovimentacaoItem::create([
                    'id_movimentacao_mit'       =>  $materialMov->id,
                    'id_material_mit'           =>  $material_id,
                    'qtd_material_mit'          =>  -$quantidade_solicitada,
                    'vlr_material_mit'          =>  -$value,
                    'tipo_movimentacao_mit'     =>  'saida',
                ]);

                $estoque_item = EstoqueItem::get($id_empresa, $materialMov->id_estoque_saida_mov, $material['id_material_mte'], $request->id_centro_custo_mov);
                $estoque_item->qtd_estoque_item_eti -= $quantidade_solicitada;
                EstoqueItem::updateReg($id_empresa, $estoque_item->id_estoque_item_eti, $estoque_item);
            }
            return response()->json($materialMov,201);
        }

    }

    /**
     * @OA\Get(
     *     path="/material-movimentacao/{id_material}",
     *     summary="Obter movimentação de material",
     *     description="Obtém a movimentação de materiais por ID ou lista de todas",
     *     @OA\Parameter(
     *         name="id_material",
     *         in="path",
     *         required=false,
     *         description="ID do material",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de movimentações",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/MaterialMovimentacao")
     *         )
     *     )
     * )
     */
    public function get(Request $request, $id_material = null)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $data = MaterialMovimentacao::get($id_empresa, $id_material);

        $input_array = $data->toArray();

        $data = $this->groupMovimentacaoMaterialByMovimentacaoMaterialItem($input_array);
        // return $data;
        return response()->json($data);
    }

    /**
     * @OA\Put(
     *     path="/material-movimentacao/{id_movimentacao}/update",
     *     summary="Atualizar movimentação de material",
     *     description="Atualiza a descrição da movimentação de material",
     *     @OA\Parameter(
     *         name="id_movimentacao",
     *         in="path",
     *         required=true,
     *         description="ID da movimentação",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"txt_movimentacao_mov"},
     *             @OA\Property(property="txt_movimentacao_mov", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movimentação atualizada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function update(Int $id_movimentacao, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'txt_movimentacao_mov' => 'required|string'
        ]);
        MaterialMovimentacao::updateReg($id_empresa, $id_movimentacao, $request);
    }

    /**
     * @OA\Delete(
     *     path="/material-movimentacao/{id_movimentacao}/delete",
     *     summary="Deletar movimentação de material",
     *     description="Desativa uma movimentação de material",
     *     @OA\Parameter(
     *         name="id_movimentacao",
     *         in="path",
     *         required=true,
     *         description="ID da movimentação",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movimentação desativada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movimentação não encontrada"
     *     )
     * )
     */
    public function delete(Request $request, Int $id_movimentacao) {
        $id_empresa = $this->getIdEmpresa($request);

        MaterialMovimentacao::deleteReg($id_empresa, $id_movimentacao);
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
