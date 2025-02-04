<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    
    public function create(Request $request) {

        $request->validate([
            'id_unidade_mte'        => 'required|int',
            'des_material_mte'      => 'required|string|max:255',
            'vlr_material_mte'      => 'required|numeric',
            'id_centro_custo_mte'   => 'required|integer|',
        ]);

        $material = Material::create([
            'id_unidade_mte'        => $request->id_unidade_mte,
            'des_material_mte'      => $request->des_material_mte,
            'vlr_material_mte'      => $request->vlr_material_mte,
            'id_centro_custo_mte'   => $request->id_centro_custo_mte,
            'is_ativo_mte'          => 1,
        ]);

        return response()->json($material,201);
    }

    public function get(Int $id_material = null) {
        if($id_material){
            $data = Material::getById(($id_material));
            $data_array = json_decode($data->content());
           
            if(empty($data_array)){
                return response()->json([
                    'error' => 'Material Não Existe',],400);
            }
            return $data;
        }
        $data = Material::getAll();
        return $data;
    }

    public function update(Int $id_material, Request $request) {
        $request->validate([
            'id_unidade_mte'        => 'int',
            'des_material_mte'      => 'string|max:255',
            'id_centro_custo_mte'   => 'integer',
            'vlr_material_mte'      => 'float'
        ]);
        Material::updateReg($id_material, $request);
    }

    // delete (inactivate)
    public function delete(Int $id_material) {
        Material::deleteReg($id_material);
    }
}
