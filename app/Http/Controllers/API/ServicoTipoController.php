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

    // read all
    public function getAll() {
        $data = ServicoTipo::getAll();
        return $data;
    }

    // read by id
    public function getById(Request $request) {
        $data = ServicoTipo::getById(($request->id_servico_tipo_stp));
        return $data;
    }

    // update
    public function updateServiceType(Request $request) {
        $data = ServicoTipo::updateServiceType($request);
        return $data;
    }

    // delete (inactivate)
    public function deleteServiceType(Request $request) {
        $data = ServicoTipo::deleteServiceType($request->id_servico_tipo_stp);
        return $data;
    }
 
}
