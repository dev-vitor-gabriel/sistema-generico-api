<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MetodoPagamento;
use Illuminate\Http\Request;

class MetodoPagamentoController extends Controller
{
    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Post(
     *     path="/metodoPagamento",
     *     summary="Cria um novo método de pagamento",
     *     tags={"MetodoPagamento"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"desc_metodo_pagamento_tmp"},
     *             @OA\Property(property="desc_metodo_pagamento_tmp", type="string", example="Cartão de Crédito"),
     *             @OA\Property(property="is_ativo_tmp", type="boolean", example=true),
     *             @OA\Property(property="id_empresa_tmp", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Método de pagamento criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/MaterialMovimentacao")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na validação dos dados",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro de validação")
     *         )
     *     )
     * )
     */
    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'desc_metodo_pagamento_tmp'       => 'required|string|max:255'
        ]);

        $metodoPagamento = MetodoPagamento::create([
            'desc_metodo_pagamento_tmp'       => $request->desc_metodo_pagamento_tmp,
            'is_ativo_tmp'                    => 1,
            'id_empresa_tmp' => $id_empresa,
        ]);

        return response()->json($metodoPagamento,201);
    }

    /**
     * @OA\Get(
     *     path="/metodoPagamento/{id_metodo_pagamento}",
     *     summary="Obtém um método de pagamento específico",
     *     tags={"MetodoPagamento"},
     *     @OA\Parameter(
     *         name="id_metodo_pagamento",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID do método de pagamento"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Método de pagamento encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/MaterialMovimentacao")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Método de pagamento não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Metodo de Pagamento Não Existe")
     *         )
     *     )
     * )
     */
    public function get(Request $request, $id_metodo_pagamento = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_metodo_pagamento){
            $data = MetodoPagamento::getById($id_empresa, $id_metodo_pagamento);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Metodo de Pagamento Não Existe',],400);
            }
            return $data;
        }
        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        return MetodoPagamento::getAll($id_empresa, $filter, $per_page, $page_number);
    }

    /**
     * @OA\Put(
     *     path="/metodoPagamento/{id_metodo_pagamento}",
     *     summary="Atualiza um método de pagamento existente",
     *     tags={"MetodoPagamento"},
     *     @OA\Parameter(
     *         name="id_metodo_pagamento",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID do método de pagamento"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"desc_metodo_pagamento_tmp"},
     *             @OA\Property(property="desc_metodo_pagamento_tmp", type="string", example="Cartão de Débito")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Método de pagamento atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na validação dos dados",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro de validação")
     *         )
     *     )
     * )
     */
    public function update(Int $id_metodo_pagamento, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'desc_metodo_pagamento_tmp'       => 'string|max:255'
        ]);
        MetodoPagamento::updateReg($id_empresa, $id_metodo_pagamento, $request);
    }

    /**
     * @OA\Delete(
     *     path="/metodoPagamento/{id_metodo_pagamento}",
     *     summary="Deleta um método de pagamento",
     *     tags={"MetodoPagamento"},
     *     @OA\Parameter(
     *         name="id_metodo_pagamento",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID do método de pagamento"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Método de pagamento deletado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Método de pagamento não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Método de pagamento não encontrado")
     *         )
     *     )
     * )
     */
    public function delete(Int $id_metodo_pagamento, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);
        MetodoPagamento::deleteReg($id_empresa, $id_metodo_pagamento);
    }
}
