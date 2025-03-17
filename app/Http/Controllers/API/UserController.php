<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user/{id_user}",
     *     summary="Obtém os dados de um usuário",
     *     tags={"Usuario"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados do usuário",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function get($id_usuario = null) {
        if ($id_usuario) {
            $id_usuario = (int) $id_usuario;
            $data = User::getById($id_usuario);
            return response()->json($data->original);
        }

        $data = User::getAll();
        return response()->json($data->original);
    }

    /**
     * @OA\Put(
     *     path="/user/{id_user}",
     *     summary="Atualiza os dados de um usuário",
     *     tags={"Usuario"},
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="url_img_user", type="string", format="uri")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuário atualizado com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validação falhou",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function update(Int $id_user, Request $request) {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:6',
            'url_img_user' => 'string'
        ]);
        User::updateReg($id_user, $request);
    }

    /**
     * @OA\Delete(
     *     path="/user/{id_user}",
     *     summary="Deleta um usuário",
     *     tags={"Usuario"},
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário deletado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuário deletado com sucesso")
     *         )
     *     )
     * )
     */
    public function delete(Int $id_user) {
        User::deleteReg($id_user);
    }
}
