<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    // create
    public function create(Request $request) {
        
        $request->validate([
            'des_servico_tipo_stp' => 'required|string|max:255',
            'txt_servico_ser' => 'required|string|max:255'
        ]);

        $servico = Servico::create([
            'des_servico_tipo_stp' => $request->des_servico_tipo_stp,
            'txt_servico_ser' => $request->txt_servico_ser,
            'is_ativo_stp' => 1,
        ]);

        return response()->json([
            'message' => 'Service created successfully',
            'service' => $servico
        ]);
    }
}
