<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    /**
     * @OA\Get(
     *     path="/material/{id_material}",
     *     summary="Obter material por ID",
     *     description="Retorna os detalhes de um material específico",
     *     operationId="getMaterialById",
     *     tags={"Material"},
     *     @OA\Parameter(
     *         name="id_material",
     *         in="path",
     *         required=true,
     *         description="ID do material",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do material",
     *         @OA\JsonContent(ref="#/components/schemas/Material")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Material não encontrado"
     *     )
     * )
     */
    public function get(Request $request, Int $id_material = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_material){
            $data = Material::getById($id_empresa, $id_material);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Material Não Existe',],400);
            }
            return $data;
        }
        $data = Material::getAll($id_empresa);
        return $data;
    }

    /**
     * @OA\Post(
     *     path="/material",
     *     summary="Criar material",
     *     description="Cria um novo material",
     *     operationId="createMaterial",
     *     tags={"Material"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="id_unidade_mte", type="integer", description="ID da unidade"),
     *                 @OA\Property(property="des_material_mte", type="string", description="Descrição do material"),
     *                 @OA\Property(property="vlr_material_mte", type="integer", description="Valor do material"),
     *                 @OA\Property(property="id_centro_custo_mte", type="integer", description="ID do centro de custo")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Material criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Material")
     *     )
     * )
     */
    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'id_unidade_mte'        => 'required|integer',
            'des_material_mte'      => 'required|string|max:255',
            'vlr_material_mte'      => 'required|numeric',
            'id_centro_custo_mte'   => 'required|integer|',
        ]);

        $material = Material::create([
            'id_unidade_mte'        => $request->id_unidade_mte,
            'des_material_mte'      => $request->des_material_mte,
            'vlr_material_mte'      => $request->vlr_material_mte,
            'id_centro_custo_mte'   => $request->id_centro_custo_mte,
            'id_empresa_mte'        => $id_empresa,
            'is_ativo_mte'          => 1,
        ]);

        return response()->json($material,201);
    }

    /**
     * @OA\Put(
     *     path="/material/{id_material}",
     *     summary="Atualizar material",
     *     description="Atualiza os dados de um material",
     *     operationId="updateMaterial",
     *     tags={"Material"},
     *     @OA\Parameter(
     *         name="id_material",
     *         in="path",
     *         required=true,
     *         description="ID do material",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="id_unidade_mte", type="integer", description="ID da unidade"),
     *                 @OA\Property(property="des_material_mte", type="string", description="Descrição do material"),
     *                 @OA\Property(property="vlr_material_mte", type="integer", description="Valor do material"),
     *                 @OA\Property(property="id_centro_custo_mte", type="integer", description="ID do centro de custo")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Material atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Material")
     *     )
     * )
     */
    public function update(Int $id_material, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'id_unidade_mte'        => 'integer',
            'des_material_mte'      => 'string|max:255',
            'id_centro_custo_mte'   => 'integer',
            'vlr_material_mte'      => 'numeric'
        ]);

        Material::updateReg($id_empresa, $id_material, $request);
    }

    /**
     * @OA\Delete(
     *     path="/material/{id_material}",
     *     summary="Excluir material",
     *     description="Desativa um material",
     *     operationId="deleteMaterial",
     *     tags={"Material"},
     *     @OA\Parameter(
     *         name="id_material",
     *         in="path",
     *         required=true,
     *         description="ID do material",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Material excluído com sucesso"
     *     )
     * )
     */
    public function delete(Request $request, Int $id_material) {
        $id_empresa = $this->getIdEmpresa($request);

        Material::deleteReg($id_empresa, $id_material);
    }
}
