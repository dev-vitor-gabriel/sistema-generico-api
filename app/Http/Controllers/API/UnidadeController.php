<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Post(
     *     path="/unidade",
     *     summary="Cria uma nova unidade",
     *     operationId="createUnidade",
     *     tags={"Unidade"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Unidade")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Unidade criada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function create(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_unidade_und'       => 'required|string|max:255',
            'des_reduz_unidade_und' => 'required|string|max:255',
            'id_centro_custo_und'   => 'required|integer|',
        ]);

        $servico_tipo = Unidade::create([
            'des_unidade_und'       => $request->des_unidade_und,
            'des_reduz_unidade_und' => $request->des_reduz_unidade_und,
            'id_centro_custo_und'   => $request->id_centro_custo_und,
            'is_ativo_stp'          => 1,
            'id_empresa'            => $id_empresa,
        ]);

        return response()->json($servico_tipo,201);
    }

    /**
     * @OA\Get(
     *     path="/unidade/{id_unidade_und}",
     *     summary="Obtém uma unidade pelo ID",
     *     operationId="getUnidadeById",
     *     tags={"Unidade"},
     *     @OA\Parameter(
     *         name="id_unidade_und",
     *         in="path",
     *         required=true,
     *         description="ID da unidade",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Unidade encontrada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Unidade não encontrada"
     *     )
     * )
     *
     * @OA\Get(
     *     path="/unidade",
     *     summary="Obtém todas as unidades",
     *     operationId="getAllUnidades",
     *     tags={"Unidade"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de unidades"
     *     )
     * )
     */
    public function get(Request $request, $id_unidade_und = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_unidade_und){
            $data = Unidade::getById(($id_unidade_und));
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Unidade Não Existe',],400);
            }
            return $data;
        }
        $data = Unidade::getAll($id_empresa);
        return $data;
    }

    /**
     * @OA\Patch(
     *     path="/unidade/{id_unidade_und}",
     *     summary="Atualiza uma unidade",
     *     operationId="updateUnidade",
     *     tags={"Unidade"},
     *     @OA\Parameter(
     *         name="id_unidade_und",
     *         in="path",
     *         required=true,
     *         description="ID da unidade",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Unidade")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Unidade atualizada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Unidade não encontrada"
     *     )
     * )
     */
    public function update(Int $id_unidade_und, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_unidade_und'       => 'string|max:255',
            'des_reduz_unidade_und' => 'string|max:255',
            'id_centro_custo_und'   => 'integer',
        ]);
        Unidade::updateReg($id_empresa, $id_unidade_und, $request);
    }

    /**
     * @OA\Delete(
     *     path="/unidade/{id_unidade_und}",
     *     summary="Exclui (inativa) uma unidade",
     *     operationId="deleteUnidade",
     *     tags={"Unidade"},
     *     @OA\Parameter(
     *         name="id_unidade_und",
     *         in="path",
     *         required=true,
     *         description="ID da unidade",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Unidade inativada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Unidade não encontrada"
     *     )
     * )
     */
    public function delete(Int $id_unidade_und, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        Unidade::deleteReg($id_empresa, $id_unidade_und);
    }

}
