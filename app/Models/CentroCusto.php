<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroCusto extends Model
{
    use HasFactory;

    protected $table = "tb_centro_custo";

    protected $fillable = [
        'des_centro_custo_cco',
        'is_ativo_cco',
        'id_empresa_cco',
    ];

    public static function getAll(Int $id_empresa) {
        $data = CentroCusto::select(['*'])
        ->where('is_ativo_cco', 1)
        ->where('id_empresa_cco', $id_empresa)
        ->orderBy('id_centro_custo_cco', 'desc')
        ->get();
        return response()
        ->json($data);
    }

    public static function getById(Int $id_empresa, Int $id = null) {
        if ($id) {
            $data = CentroCusto::select(['*'])
            ->where('id_centro_custo_cco', $id)
            ->where('is_ativo_cco', 1)
            ->where('id_empresa_cco', $id_empresa)
            ->orderBy('id_centro_custo_cco', 'desc')
            ->get();
        } else{
            $data = CentroCusto::select(['*'])
            ->where('is_ativo_cco', 1)
            ->where('id_empresa_cco', $id_empresa)
            ->orderBy('id_centro_custo_cco', 'desc')
            ->get();
        }
        return response()
        ->json($data);
    }

    public static function updateReg(Int $id_empresa, Int $id_centro_custo, $obj) {
        CentroCusto::
        where('id_centro_custo_cco', $id_centro_custo)
        ->where('id_empresa_cco', $id_empresa)
        ->update([
            'des_centro_custo_cco' => $obj
            ->des_centro_custo_cco
        ]);
    }

    public static function deleteReg($id_empresa, $id_cliente) {
        CentroCusto::
        where('id_centro_custo_cco', $id_cliente)
        ->where('id_empresa_cco', $id_empresa)
        ->update([
            'is_ativo_cco' => 0
        ]);
    }

}
