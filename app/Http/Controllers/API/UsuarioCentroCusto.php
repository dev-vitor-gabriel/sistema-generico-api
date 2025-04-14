<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RelUsuarioCentroCusto;

class UsuarioCentroCusto extends Controller
{
    public function create(Request $request) {
        $existingRecords = RelUsuarioCentroCusto::where('id_user', $request->id_user)
        ->pluck('id_centro_custo_ccu')
        ->toArray();

        $centroCustoParaRemover = array_diff($existingRecords, $request->id_centro_custo_ccu);
        RelUsuarioCentroCusto::where('id_user', $request->id_user)
            ->whereIn('id_centro_custo_ccu', $centroCustoParaRemover)
            ->delete();

        $centroCustoParaAdicionar = array_diff($request->id_centro_custo_ccu, $existingRecords);
        $rel_usuario_centro_custo = [];
        foreach ($centroCustoParaAdicionar as $centro_custo_id) {
            $rel_usuario_centro_custo[] = RelUsuarioCentroCusto::create([
                'id_centro_custo_ccu'    => $centro_custo_id,
                'id_user' => $request->id_user
            ]);
        }

        return response()->json([], 201);
    }

    public function getCentroCustoByIdUsuario(Int $id_usuario)
    {
        $data = RelUsuarioCentroCusto::getCentroCustoByIdUsuario($id_usuario);

        return response()->json($data, 200);
    }
}
