<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use App\Helpers\ValidateString;

class FornecedorController extends Controller
{
    public function create(Request $request){
       
        $request->validate([
            'desc_fornecedor_frn'      => 'required|string|',
            'tel_fornecedor_frn'       => 'required|string|',
            'documento_fornecedor_frn' => 'string|',
        ]);

        $fornecedor = Fornecedor::create([
            'desc_fornecedor_frn'      => $request->desc_fornecedor_frn,
            'tel_fornecedor_frn'       => ValidateString::removeCharacterSpecial($request->tel_fornecedor_frn),
            'documento_fornecedor_frn' => ValidateString::removeCharacterSpecial($request->documento_fornecedor_frn)
        ]);

        return response()->json($fornecedor,201); 
    }

    public function get(Int $id_fornecedor = null){

        if($id_fornecedor){
            $data = Fornecedor::getById($id_fornecedor);
            $data_array = json_decode($data->content());
           
            if(empty($data_array)){
                return response()->json([
                    'error' => 'Fornecedor Não Existe'],400);
            }
            return $data;
        }
        $data = Fornecedor::getAll();
        return $data;
    }

    public function update(Int $id_fornecedor, Request $request){
        $request->validate([
            'desc_fornecedor_frn'      => 'string',
            'tel_fornecedor_frn'       => 'string',
            'documento_fornecedor_frn' => 'string',
        ]);
        Fornecedor::updateReg($id_fornecedor, $request);
    }

    // delete (inactivate)
    public function delete(Int $id_fornecedor){
        Fornecedor::deleteReg($id_fornecedor);
    }
}
