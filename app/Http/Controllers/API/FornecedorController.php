<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use App\Helpers\ValidateString;

class FornecedorController extends Controller
{
    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    public function create(Request $request){
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'desc_fornecedor_frn'      => 'required|string|',
            'tel_fornecedor_frn'       => 'required|string|',
            'documento_fornecedor_frn' => 'string|',
        ]);

        $fornecedor = Fornecedor::create([
            'desc_fornecedor_frn'      => $request->desc_fornecedor_frn,
            'tel_fornecedor_frn'       => ValidateString::removeCharacterSpecial($request->tel_fornecedor_frn),
            'documento_fornecedor_frn' => ValidateString::removeCharacterSpecial($request->documento_fornecedor_frn),
            'id_empresa_frn' => $id_empresa,
        ]);

        return response()->json($fornecedor,201);
    }

    public function get(Request $request, Int $id_fornecedor = null){
        $id_empresa = $this->getIdEmpresa($request);

        if($id_fornecedor){
            $data = Fornecedor::getById($id_empresa, $id_fornecedor);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Fornecedor Não Existe'],400);
            }
            return $data;
        }
        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        return Fornecedor::getAll($id_empresa, $filter, $per_page, $page_number);
    }

    public function update(Int $id_fornecedor, Request $request){
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'desc_fornecedor_frn'      => 'string',
            'tel_fornecedor_frn'       => 'string',
            'documento_fornecedor_frn' => 'string',
        ]);
        Fornecedor::updateReg($id_fornecedor,$id_empresa, $request);
    }

    // delete (inactivate)
    public function delete(Request $request, Int $id_fornecedor) {
        $id_empresa = $this->getIdEmpresa($request);

        Fornecedor::deleteReg($id_fornecedor, $id_empresa);
    }
}
