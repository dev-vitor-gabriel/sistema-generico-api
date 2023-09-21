<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CentroCusto;
use Illuminate\Http\Request;

class CentroCustoController extends Controller
{
    public function create(Request $request) {

        $request->validate([
            'des_centro_custo_cco' => 'required|string|max:255'
        ]); 

        $cliente = CentroCusto::create([
            'des_centro_custo_cco' => $request->des_centro_custo_cco
        ]);

        return response()->json($cliente,201);
    }

    public function get(Int $id_centro_custo = null) {
        if($id_centro_custo){
            $data = CentroCusto::getById(($id_centro_custo));
            return $data;
        }
        $data = CentroCusto::getAll();
        return $data;
    }

    public function update(Int $id_centro_custo, Request $request) {
        $request->validate([
            'des_centro_custo_cco' => 'required|string|max:255'
        ]);
        CentroCusto::updateReg($id_centro_custo, $request);
    }

    public function delete(Int $id_centro_custo) {
        CentroCusto::deleteReg($id_centro_custo);
    }
}
