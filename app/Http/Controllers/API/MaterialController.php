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
            'id_unidade_mte' =>  'required|int',
            'des_material_mte' => 'required|string|max:255',
            'vlr_material_mte' => 'required|numeric'
        ]);

        $material = Material::create([
            'id_unidade_mte'    => $request->id_unidade_mte,
            'des_material_mte'  => $request->des_material_mte,
            'vlr_material_mte'  => $request->vlr_material_mte,
            'is_ativo_mte'      => 1,
            'id_empresa_mte'    => $id_empresa,
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
            'id_unidade_mte' =>  'int',
            'des_material_mte' => 'string|max:255',
            'vlr_material_mte' => 'float'
        ]);
        Material::updateReg($id_empresa, $id_material, $request);
    }

    // delete (inactivate)
    public function delete(Request $request, Int $id_material) {
        $id_empresa = $this->getIdEmpresa($request);

        Material::deleteReg($id_empresa, $id_material);
    }
}
