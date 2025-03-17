<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Helpers\ValidateString;
use Illuminate\Support\Facades\Validator;


class ClienteController extends Controller
{
    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Post(
     *     path="/cliente",
     *     summary="Cria um novo cliente",
     *     tags={"Cliente"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $document_formated = ValidateString::removeCharacterSpecial($request->documento_cliente_cli);

        $request->merge(['documento_cliente_cli' => $document_formated]);

        $validator = Validator::make($request->all(), [
            'des_cliente_cli'       => 'required|string|max:255',
            'telefone_cliente_cli'  => 'required|string|max:11',
            'email_cliente_cli'     => 'required|string|max:255',
            'documento_cliente_cli' => 'string|max:11',
            'endereco_cliente_cli'  => 'string|max:255',
            'id_centro_custo_cli'   => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cliente = Cliente::create([
            'des_cliente_cli'       => $request->des_cliente_cli,
            'telefone_cliente_cli'  => $request->telefone_cliente_cli,
            'email_cliente_cli'     => $request->email_cliente_cli,
            'documento_cliente_cli' => $request->documento_cliente_cli,
            'endereco_cliente_cli'  => $request->endereco_cliente_cli,
            'id_centro_custo_cli'   => $request->id_centro_custo_cli,
            'id_empresa'            => $id_empresa,
            'is_ativo_cli'          => 1,
        ]);


        return response()->json($cliente,201);
    }

     /**
     * @OA\Get(
     *     path="/cliente/{id_cliente}",
     *     summary="Obtém um cliente pelo ID",
     *     tags={"Cliente"},
     *     @OA\Parameter(
     *         name="id_cliente",
     *         in="path",
     *         required=false,
     *         description="ID do cliente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Cliente não encontrado"
     *     )
     * )
     */
    public function get(Request $request, $id_cliente = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_cliente){
            $data = Cliente::getById($id_empresa, $id_cliente);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Cliente Não Existe',],400);
            }
            return $data;
        }
        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        return Cliente::getAll($id_empresa, $filter, $per_page, $page_number);
    }

    /**
     * @OA\Put(
     *     path="/cliente/{id_cliente}",
     *     summary="Atualiza um cliente",
     *     tags={"Cliente"},
     *     @OA\Parameter(
     *         name="id_cliente",
     *         in="path",
     *         required=true,
     *         description="ID do cliente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function update(Int $id_cliente, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $document_formated = ValidateString::removeCharacterSpecial($request->documento_cliente_cli);
        $request->merge(['documento_cliente_cli' => $document_formated]);
        $validator = Validator::make($request->all(),[
            'des_cliente_cli'       => 'required|string|max:255',
            'telefone_cliente_cli'  => 'required|string|max:11',
            'email_cliente_cli'     => 'required|string|max:255',
            'documento_cliente_cli' => 'string|max:11',
            'endereco_cliente_cli'  => 'string|max:255',
            'id_centro_custo_cli'   => 'integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Cliente::updateReg($id_empresa, $id_cliente, $request);

    }

    /**
     * @OA\Delete(
     *     path="/cliente/{id_cliente}",
     *     summary="Deleta um cliente",
     *     tags={"Cliente"},
     *     @OA\Parameter(
     *         name="id_cliente",
     *         in="path",
     *         required=true,
     *         description="ID do cliente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente deletado com sucesso"
     *     )
     * )
     */
    public function delete(Int $id_cliente, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        Cliente::deleteReg($id_empresa, $id_cliente);
    }
}
