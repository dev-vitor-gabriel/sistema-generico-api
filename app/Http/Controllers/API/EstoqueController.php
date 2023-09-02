<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Estoque;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function create(Request $request) {

        $request->validate([
            'des_estoque_est' => 'required|string|max:255'
        ]); 

        $material = Estoque::create([
            'des_estoque_est' => $request->des_estoque_est,
            'is_ativo_est' => 1,
        ]);

        return response()->json($material,201);
    }

    public function get(Int $id_estoque = null) {
        if($id_estoque){
            $data = Estoque::getById(($id_estoque));
            return $data;
        }
        $data = Estoque::getAll();
        return $data;
    }

    public function update(Int $id_estoque, Request $request) {
        $request->validate([
            'des_estoque_est' => 'required|string|max:255'
        ]); 
        Estoque::updateReg($id_estoque, $request);
    }

    // delete (inactivate)
    public function delete(Int $id_estoque) {
        Estoque::deleteReg($id_estoque);
    }
}
