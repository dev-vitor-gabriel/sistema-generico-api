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

    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'id_unidade_mte'        => 'required|integer',
            'des_material_mte'      => 'required|string|max:255',
            'vlr_material_mte'      => 'required|numeric',
            'id_centro_custo_mte'   => 'required|integer|',
        ]);

        $material = Material::create([
            'id_unidade_mte'        => $request->id_unidade_mte,
            'des_material_mte'      => $request->des_material_mte,
            'vlr_material_mte'      => $request->vlr_material_mte,
            'id_centro_custo_mte'   => $request->id_centro_custo_mte,
            'id_empresa_mte'        => $id_empresa,
            'is_ativo_mte'          => 1,
        ]);

        return response()->json($material,201);
    }

    public function get(Request $request, Int $id_material = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_material){
            $data = Material::getById($id_empresa, $id_material);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Material Não Existe',],400);
            }
            return $data;
        }
        $data = Material::getAll($id_empresa);
        return $data;
    }

    public function update(Int $id_material, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'id_unidade_mte'        => 'integer',
            'des_material_mte'      => 'string|max:255',
            'id_centro_custo_mte'   => 'integer',
            'vlr_material_mte'      => 'numeric'
        ]);

        Material::updateReg($id_empresa, $id_material, $request);
    }

    // delete (inactivate)
    public function delete(Request $request, Int $id_material) {
        $id_empresa = $this->getIdEmpresa($request);

        Material::deleteReg($id_empresa, $id_material);
    }
}
