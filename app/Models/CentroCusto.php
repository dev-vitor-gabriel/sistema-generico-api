<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroCusto extends Model
{
    use HasFactory;

    protected $table = "tb_centro_custo";

    protected $primaryKey = 'id_centro_custo_cco_tcg';

    protected $fillable = [
        'des_centro_custo_cco',
        'is_ativo_cco',
        'id_empresa_cco',
    ];

    public static function getAll($id_empresa, $filter, $perPage = 10, $pageNumber = 1) {
        $paginator = CentroCusto::select(['*'])
        ->where('is_ativo_cco', 1)
        ->where('des_centro_custo_cco', 'like', '%'.$filter.'%')
        ->where('id_empresa_cco', $id_empresa)
        ->orderBy('id_centro_custo_cco', 'desc')
        ->paginate($perPage, ['*'], 'page', $pageNumber);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function getById(Int $id_empresa, Int $id_centro_custo) {
        $data = CentroCusto::select(['*'])
        ->where('id_centro_custo_cco', $id_centro_custo)
        ->where('is_ativo_cco', 1)
        ->where('id_empresa_cco', $id_empresa)
        ->orderBy('id_centro_custo_cco', 'desc')
        ->first();
        
        return $data;
    }

    public static function updateReg(Int $id_empresa, Int $id_centro_custo, $dados_atualizados) {
        CentroCusto::
        where('id_centro_custo_cco', $id_centro_custo)
        ->where('id_empresa_cco', $id_empresa)
        ->update($dados_atualizados);
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
