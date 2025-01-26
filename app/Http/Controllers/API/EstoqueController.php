<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Estoque;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{

    public function create(Request $request) {

        $request->validate([
            'des_estoque_est'     => 'required|string|max:255',
            'id_centro_custo_est' => 'required|integer|exists:tb_centro_custo,id_centro_custo_cco'
        ]);

        $estoque = Estoque::create([
            'des_estoque_est'            => $request->des_estoque_est,
            'id_centro_custo_est'        => $request->id_centro_custo_est
        ]);

        return response()->json($estoque,201);
    }

    public function get(Int $id_estoque = null) {
        if($id_estoque){
            $data = Estoque::getById(($id_estoque));
            return $data;
        }
        $data = Estoque::getAll();
        return $data;
    }

    public function showEstoqueComValores()
    {
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


    // public function showEstoqueComValores() {
    //     $dados = Estoque::getEstoqueComValores();
    //     // Formatando a resposta para agrupar os estoques
    //     $result = [];

    //     foreach ($dados as $item) {
    //         $estoqueId = $item->estoque_id;
    //         if (!isset($result[$estoqueId])) {
    //             $result[$estoqueId] = [
    //                 'estoque_id' => $item->estoque_id,
    //                 'estoque_descricao' => $item->estoque_descricao,
    //                 'materiais' => []
    //             ];
    //         }

    //         $result[$estoqueId]['materiais'][] = [
    //             'material_descricao' => $item->material_descricao,
    //             'valor_unitario' => $item->valor_unitario,
    //             'quantidade_em_estoque' => $item->quantidade_em_estoque,
    //             'valor_total_em_estoque' => $item->valor_total_em_estoque
    //         ];
    //     }

    //     // Convertendo o resultado em um array
    //     $response = array_values($result);

    //     return response()->json($response);
    // }

    public function delete(Int $id_estoque) {
        Estoque::deleteReg($id_estoque);
    }
}
