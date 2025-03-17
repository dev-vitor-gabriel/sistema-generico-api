<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use App\Helpers\ValidateString;

class PessoaController extends Controller
{

    /**
     * @OA\Post(
     *     path="/pessoa",
     *     summary="Cria uma nova pessoa",
     *     description="Cria uma nova pessoa com os dados fornecidos.",
     *     tags={"Pessoa"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"nome_pessoa_pes", "id_centro_custo_pes"},
     *                 @OA\Property(property="nome_pessoa_pes", type="string", description="Nome da pessoa"),
     *                 @OA\Property(property="id_centro_custo_pes", type="integer", description="ID do centro de custo"),
     *                 @OA\Property(property="documento_pessoa_pes", type="string", description="Documento de identificação")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pessoa criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Pessoa")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function create(request $request){

        $request->validate([
            'nome_pessoa_pes'           => 'required|string|',
            'id_centro_custo_pes'       => 'required|integer|',
            'documento_pessoa_pes'      => 'string|',
        ]);

        $pessoa = Pessoa::create([
            'nome_pessoa_pes'           => $request->nome_pessoa_pes,
            'id_centro_custo_pes'       => $request->id_centro_custo_pes,
            'documento_pessoa_pes'      => ValidateString::removeCharacterSpecial($request->documento_pessoa_pes)
        ]);
        return response()->json($pessoa,201);
    }

    /**
     * @OA\Get(
     *     path="/pessoa/{id_pessoa}",
     *     summary="Retorna uma pessoa por ID",
     *     description="Retorna os detalhes de uma pessoa com base no ID fornecido.",
     *     tags={"Pessoa"},
     *     @OA\Parameter(
     *         name="id_pessoa",
     *         in="path",
     *         required=true,
     *         description="ID da pessoa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da pessoa",
     *         @OA\JsonContent(ref="#/components/schemas/Pessoa")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Pessoa não encontrada"
     *     )
     * )
     */
    public function get($id_pessoa = null){

        if($id_pessoa){
            $data = Pessoa::getById($id_pessoa);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'erro'=> 'Pessoa Não Existe'
                ],400);
            }
            return $data;
        }
        $data = Pessoa::getAll();
        return $data;
    }

    /**
     * @OA\Put(
     *     path="/pessoa/{id_pessoa}",
     *     summary="Atualiza os dados de uma pessoa",
     *     description="Atualiza os dados de uma pessoa com base no ID fornecido.",
     *     tags={"Pessoa"},
     *     @OA\Parameter(
     *         name="id_pessoa",
     *         in="path",
     *         required=true,
     *         description="ID da pessoa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="nome_pessoa_pes", type="string", description="Nome da pessoa"),
     *                 @OA\Property(property="id_centro_custo_pes", type="integer", description="ID do centro de custo"),
     *                 @OA\Property(property="documento_pessoa_pes", type="string", description="Documento de identificação")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pessoa atualizada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação ou pessoa não encontrada"
     *     )
     * )
     */
    public function update(Int $id_pessoa, request $request){
        $request->validate([
            'nome_pessoa_pes'           => 'string',
            'id_centro_custo_pes'       => 'integer',
            'documento_pessoa_pes'      => 'string',
        ]);
        Pessoa::updateReg($id_pessoa, $request);
    }

    /**
     * @OA\Delete(
     *     path="/pessoa/{id_pessoa}",
     *     summary="Deleta uma pessoa",
     *     description="Deleta uma pessoa com base no ID fornecido.",
     *     tags={"Pessoa"},
     *     @OA\Parameter(
     *         name="id_pessoa",
     *         in="path",
     *         required=true,
     *         description="ID da pessoa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pessoa deletada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Pessoa não encontrada"
     *     )
     * )
     */
    public function delete(Int $id_pessoa){
        Pessoa::deleteReg($id_pessoa);
    }
}
