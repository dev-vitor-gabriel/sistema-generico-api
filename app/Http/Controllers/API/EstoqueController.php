<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\EstoqueRepositoryInterface;
use App\Models\Estoque;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function __construct(
        private EstoqueRepositoryInterface $estoqueRepository
     )
     {
     }
     
     public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }


    /**
     * @OA\Get(
     *     path="/estoque/{id_estoque}",
     *     summary="Obtém um estoque pelo ID",
     *     tags={"Estoque"},
     *     @OA\Parameter(
     *         name="id_estoque",
     *         in="path",
     *         required=true,
     *         description="ID do estoque",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estoque encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Estoque")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Estoque não encontrado"
     *     )
     * )
     */
    public function get(Request $request, Int $id_estoque = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if ($id_estoque) {
            $data = $this->estoqueRepository->getById($id_empresa, $id_estoque);
            $data_array = json_decode($data->content());

            if (empty($data_array)) {
                return response()->json([
                    'error' => 'Estoque Não Existe',
                ], 400);
            }
            return $data;
        }

        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        $result = $this->estoqueRepository->getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    /**
     * @OA\Post(
     *     path="/estoque",
     *     summary="Cria um novo estoque",
     *     tags={"Estoque"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Estoque")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Estoque criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Estoque")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_estoque_est'     => 'required|string|max:255',
            'id_centro_custo_est' => 'required|integer|exists:tb_centro_custo,id_centro_custo_cco'
        ]);

        $estoque = $this->estoqueRepository->create($request->all(), $id_empresa);

        return response()->json($estoque,201);
    }

    /**
     * @OA\Put(
     *     path="/estoque/{id_estoque}",
     *     summary="Atualiza um estoque",
     *     tags={"Estoque"},
     *     @OA\Parameter(
     *         name="id_estoque",
     *         in="path",
     *         required=true,
     *         description="ID do estoque",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Estoque")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estoque atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function update(Int $id_estoque, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_estoque_est'     => 'required|string|max:255',
            'id_centro_custo_est' => 'required|integer|exists:tb_centro_custo,id_centro_custo_cco'
        ]);

        $estoque = Estoque::find($id_estoque, $id_empresa); 
        $estoque->des_estoque_est = $request->des_estoque_est;
        $estoque->id_centro_custo_est = $request->id_centro_custo_est;
        $estoque->save();

        return response()->json($estoque);
    }

    /**
     * @OA\Delete(
     *     path="/estoque/{id_estoque}",
     *     summary="Deleta um estoque",
     *     tags={"Estoque"},
     *     @OA\Parameter(
     *         name="id_estoque",
     *         in="path",
     *         required=true,
     *         description="ID do estoque",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estoque deletado com sucesso"
     *     )
     * )
     */
    public function delete(Request $request, Int $id_estoque) {
        $id_empresa = $this->getIdEmpresa($request);

       $inactive_estoque = $this->estoqueRepository->deleteReg($id_estoque, $id_empresa);

       return response()->json($inactive_estoque, 200);
    }

    /**
     * @OA\Get(
     *     path="/estoque/valores",
     *     summary="Obtém os estoques com valores e materiais associados",
     *     tags={"Estoque"},
     *     @OA\Response(
     *         response=200,
     *         description="Estoque com valores encontrados",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="estoque_id", type="integer"),
     *                 @OA\Property(property="estoque_descricao", type="string"),
     *                 @OA\Property(property="materiais", type="array", @OA\Items(
     *                     @OA\Property(property="material_descricao", type="string"),
     *                     @OA\Property(property="valor_unitario", type="number", format="float"),
     *                     @OA\Property(property="quantidade_em_estoque", type="number", format="float"),
     *                     @OA\Property(property="valor_total_em_estoque", type="number", format="float")
     *                 ))
     *             )
     *         )
     *     )
     * )
     */
    public function showEstoqueComValores() {
        $dados = Estoque::getEstoqueComValores();

        $result = [];
        foreach ($dados as $item) {
            $estoqueId = $item->estoque_id;
            if (!isset($result[$estoqueId])) {
                $result[$estoqueId] = [
                    'estoque_id' => $item->estoque_id,
                    'estoque_descricao' => $item->estoque_descricao,
                    'materiais' => []
                ];
            }

            $result[$estoqueId]['materiais'][] = [
                'material_descricao' => $item->material_descricao,
                'valor_unitario' => $item->valor_unitario,
                'quantidade_em_estoque' => $item->quantidade_em_estoque,
                'valor_total_em_estoque' => $item->valor_total_em_estoque
            ];
        }

        return response()->json(array_values($result));
    }
}
