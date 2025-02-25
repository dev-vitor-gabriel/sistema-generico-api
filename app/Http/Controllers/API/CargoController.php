<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }
    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'desc_cargo_tcg' => 'required|string|max:255'
        ]);

        $cargo = Cargo::create([
            'desc_cargo_tcg' => $request->desc_cargo_tcg,
            'id_empresa'     => $id_empresa,
        ]);

        return response()->json($cargo,201);
    }

    public function get(Request $request, Int $id_cargo = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_cargo){
            $data = Cargo::getById($id_cargo, $id_empresa);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Cargo Não Existe',],400);
            }
            return $data;
        }

        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        return Cargo::getAll($id_empresa, $filter, $per_page, $page_number);
    }

    public function update(Request $request, Int $id_cargo) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'desc_cargo_tcg' => 'required|string|max:255'
        ]);
        Cargo::updateReg($id_empresa, $id_cargo, $request);
    }

    public function delete(Request $request, Int $id_cargo) {
        $id_empresa = $this->getIdEmpresa($request);
        Cargo::deleteReg($id_empresa, $id_cargo);
    }

}
