<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;
    protected $table = "tb_estoque";

    protected $fillable = [
        'des_estoque_est',
        'id_centro_custo_est',
        'is_ativo_est'
    ];

    public static function getAll() {
        $data = Estoque::select([
        'tb_estoque.id_estoque_est',
        'tb_estoque.des_estoque_est',
        'tb_centro_custo.des_centro_custo_cco',
        'tb_estoque.created_at' ,
        'tb_estoque.updated_at'
        ])
        ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_estoque.id_estoque_est')
        ->where('is_ativo_est', 1)
        ->orderBy('tb_estoque.id_estoque_est', 'desc')
        ->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {
        if($id) {
            $data = Estoque::select([
                'tb_estoque.id_estoque_est',
                'tb_estoque.des_estoque_est',
                'tb_centro_custo.des_centro_custo_cco',
                'tb_estoque.created_at' ,
                'tb_estoque.updated_at'
                ])
                ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_estoque.id_estoque_est')
                ->where('is_ativo_est', 1)
                ->orderBy('tb_estoque.id_estoque_est', 'desc')
                ->where('id_estoque_est', $id)
                ->get();
        }else{
            $data = Estoque::select([
                'tb_estoque.id_estoque_est',
                'tb_estoque.des_estoque_est',
                'tb_centro_custo.des_centro_custo_cco',
                'tb_estoque.created_at' ,
                'tb_estoque.updated_at'
                ])
                ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_estoque.id_estoque_est')
                ->where('is_ativo_est', 1)
                ->orderBy('tb_estoque.id_estoque_est', 'desc')
                ->get();
        }
        return response()->json($data);
    }

}
