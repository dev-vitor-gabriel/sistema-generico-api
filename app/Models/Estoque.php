<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_estoque.id_centro_custo_est')
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
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_estoque.id_centro_custo_est')
            ->where('is_ativo_est', 1)
            ->orderBy('tb_estoque.id_estoque_est', 'desc')
            ->where('id_estoque_est', $id)
            ->get();
        } else {
            $data = Estoque::select([
                'tb_estoque.id_estoque_est',
                'tb_estoque.des_estoque_est',
                'tb_centro_custo.des_centro_custo_cco',
                'tb_estoque.created_at' ,
                'tb_estoque.updated_at'
            ])
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_estoque.id_centro_custo_est')
            ->where('is_ativo_est', 1)
            ->orderBy('tb_estoque.id_estoque_est', 'desc')
            ->get();
        }
        return response()->json($data);
    }

    public static function getEstoqueComValores()
    {
        return DB::table('tb_estoque as te')
            ->leftJoin('tb_material_movimentacao as tmm', function ($join) {
                $join->on('te.id_estoque_est', '=', 'tmm.id_estoque_entrada_mov')
                     ->orOn('te.id_estoque_est', '=', 'tmm.id_estoque_saida_mov');
            })
            ->leftJoin('tb_material_movimentacao_item as tmmi', 'tmm.id_movimentacao_mov', '=', 'tmmi.id_movimentacao_mit')
            ->leftJoin('tb_material as tm', 'tmmi.id_material_mit', '=', 'tm.id_material_mte')
            ->select(
                'te.id_estoque_est as estoque_id',
                'te.des_estoque_est as estoque_descricao',
                'tm.des_material_mte as material_descricao',
                'tm.vlr_material_mte as valor_unitario',
                DB::raw('COALESCE(SUM(CASE WHEN tmm.id_estoque_entrada_mov = te.id_estoque_est THEN tmmi.qtd_material_mit ELSE 0 END), 0) - COALESCE(SUM(CASE WHEN tmm.id_estoque_saida_mov = te.id_estoque_est THEN tmmi.qtd_material_mit ELSE 0 END), 0) as quantidade_em_estoque'),
                DB::raw('(COALESCE(SUM(CASE WHEN tmm.id_estoque_entrada_mov = te.id_estoque_est THEN tmmi.qtd_material_mit ELSE 0 END), 0) - COALESCE(SUM(CASE WHEN tmm.id_estoque_saida_mov = te.id_estoque_est THEN tmmi.qtd_material_mit ELSE 0 END), 0)) * tm.vlr_material_mte as valor_total_em_estoque')
            )
            ->where('te.is_ativo_est', 1)
            ->where('tm.is_ativo_mte', 1)
            ->groupBy('te.id_estoque_est', 'tm.id_material_mte', 'tm.vlr_material_mte')
            ->orderBy('te.id_estoque_est', 'asc')
            ->orderBy('tm.des_material_mte', 'asc')
            ->get();
    }
}
