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
}
