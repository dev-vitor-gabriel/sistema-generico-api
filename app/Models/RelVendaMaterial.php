<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelVendaMaterial extends Model
{
    use HasFactory;

    protected $table = 'rel_venda_material';

    protected $fillable = [
        'id_material_rvm',
        'id_venda_rvm',
        'vlr_unit_material_rvm',
        'qtd_material_rvm',
        'id_estoque_item_eti'
    ];

    public static function deleteReg($id)
    {
        RelVendaMaterial::where('id', $id)
            ->delete();
    }

    public static function updateReg(Int $id, $obj) {
        RelVendaMaterial::where('id', $id)
        ->update($obj);
    }

    public static function getByIdVenda(Int $id_venda) {
        $materiaisVenda = RelVendaMaterial::where('id_venda_rvm', $id_venda)->get();

        return $materiaisVenda->toArray();
    }

    public static function getTotalMateriaisPorVenda($centrosCusto = [], $dataInicio = null, $dataFim = null)
    {
        $query = RelVendaMaterial::query()
            ->from('rel_venda_material as rvm')
            ->join('tb_venda as tv', 'tv.id_venda_vda', '=', 'rvm.id_venda_rvm')
            ->join('tb_material as tm', 'tm.id_material_mte', '=', 'rvm.id_material_rvm')
            ->join('tb_centro_custo as tcc', 'tcc.id_centro_custo_cco', '=', 'tv.id_centro_custo_vda');

        if (!empty($centrosCusto)) {
            $query->whereIn('tcc.id_centro_custo_cco', $centrosCusto);
        }

        if ($dataInicio && $dataFim) {
            $query->whereBetween('tv.created_at', [$dataInicio, $dataFim]);
        }

        return $query->select([
                'tm.des_material_mte as nome_material',
                RelVendaMaterial::raw('SUM(rvm.qtd_material_rvm) as quantidade_vendida')
            ])
            ->groupBy('tm.id_material_mte', 'tm.des_material_mte')
            ->orderByDesc('quantidade_vendida')
            ->limit(10)
            ->get();
    }

    public static function getValorMateriaisPorVenda($centrosCusto = [], $dataInicio = null, $dataFim = null)
    {
        $query = RelVendaMaterial::query()
            ->from('rel_venda_material as rvm')
            ->join('tb_venda as tv', 'tv.id_venda_vda', '=', 'rvm.id_venda_rvm')
            ->join('tb_material as tm', 'tm.id_material_mte', '=', 'rvm.id_material_rvm')
            ->join('tb_centro_custo as tcc', 'tcc.id_centro_custo_cco', '=', 'tv.id_centro_custo_vda');

        if (!empty($centrosCusto)) {
            $query->whereIn('tcc.id_centro_custo_cco', $centrosCusto);
        }

        if ($dataInicio && $dataFim) {
            $query->whereBetween('tv.created_at', [$dataInicio, $dataFim]);
        }

        return $query->select([
                'tm.des_material_mte as nome_material',
                RelVendaMaterial::raw('SUM(rvm.qtd_material_rvm * rvm.vlr_unit_material_rvm) as valor_total_vendido')
            ])
            ->groupBy('tm.id_material_mte', 'tm.des_material_mte')
            ->orderByDesc('valor_total_vendido')
            ->limit(10)
            ->get();
    }

}
