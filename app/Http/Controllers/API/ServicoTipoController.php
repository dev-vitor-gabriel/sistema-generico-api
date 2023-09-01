<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ServicoTipo;
use Illuminate\Http\Request;

class ServicoTipoController extends Controller
{
     // create
     public function create(Request $request) {
        
        $request->validate([
            'des_servico_tipo_stp' => 'required|string|max:255'
        ]); 

        $servicoTipo = ServicoTipo::create([
            'des_servico_tipo_stp' => $request->des_servico_tipo_stp,
            'is_ativo_stp' => 1,
        ]);

        return response()->json([
            'message' => 'Service type created successfully',
            'service' => $servicoTipo
        ]);
    }
}
