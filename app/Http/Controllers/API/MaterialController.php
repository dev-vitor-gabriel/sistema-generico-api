<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function create(Request $request) {

        $request->validate([
            'id_unidade_mte' =>  'required|int',
            'des_material_mte' => 'required|string|max:255',
            'vlr_material_mte' => 'required|numeric'
        ]);

        $material = Material::create([
            'id_unidade_mte' => $request->id_unidade_mte,
            'des_material_mte' => $request->des_material_mte,
            'vlr_material_mte' => $request->vlr_material_mte,
            'is_ativo_mte' => 1,
        ]);

        return response()->json($material,201);
    }

    public function get(Int $id_material = null) {
        if($id_material){
            $data = Material::getById(($id_material));
            return $data;
        }
        $data = Material::getAll();
        return $data;
    }

    public function update(Int $id_material, Request $request) {
        $request->validate([
            'id_unidade_mte' =>  'int',
            'des_material_mte' => 'string|max:255',
            'vlr_material_mte' => 'float'
        ]);
        Material::updateReg($id_material, $request);
    }

    // delete (inactivate)
    public function delete(Int $id_material) {
        Material::deleteReg($id_material);
    }
}
