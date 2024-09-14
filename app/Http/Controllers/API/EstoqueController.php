<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Estoque;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{

    public function get(Int $id_estoque = null) {
        if($id_estoque){
            $data = Estoque::getById(($id_estoque));
            return $data;
        }
        $data = Estoque::getAll();
        return $data;
    }

    public function showEstoqueComValores() {
        $dados = Estoque::getEstoqueComValores();

        // Formatando a resposta para agrupar os estoques
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

        // Convertendo o resultado em um array
        $response = array_values($result);

        return response()->json($response);
    }

}
