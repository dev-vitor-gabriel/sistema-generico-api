<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function create(Request $request) {

        $request->validate([
            'des_unidade_und' => 'required|string|max:255',
        ]);

        $servico_tipo = Unidade::create([
            'des_unidade_und' => $request->des_unidade_und,
            'is_ativo_stp' => 1,
        ]);

        return response()->json($servico_tipo,201);
    }

    public function get(Int $id_unidade_und = null) {
        if($id_unidade_und){
            $data = Unidade::getById(($id_unidade_und));
            return $data;
        }
        $data = Unidade::getAll();
        return $data;
    }

    public function update(Int $id_unidade_und, Request $request) {
        $request->validate([
            'des_unidade_und' => 'required|string|max:255',
        ]);
        Unidade::updateReg($id_unidade_und, $request);
    }

    public function delete(Int $id_unidade_und) {
        Unidade::deleteReg($id_unidade_und);
    }

}
