<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venda extends Model
{
    use HasFactory;

    protected $table = "tb_venda";


    protected $fillable = [
        'id_venda_vda',
        'id_funcionario_vda',
        'desc_venda_vda'
    ];

    public static function get(Int $id = null, $filtros = null)
    {
        $data = Venda::select([
            'tb_venda.id_venda_vda',
            'tb_venda.id_funcionario_vda',
            'tb_funcionarios.desc_funcionario_tfu',
            DB::raw('SUM(rel_venda_material.vlr_unit_material_rvm * rel_venda_material.qtd_material_rvm) as total_vlr_material')
            ])
            ->join('tb_funcionarios', 'tb_venda.id_funcionario_vda', '=', 'tb_funcionarios.id_funcionario_tfu')
            ->join('rel_venda_material', 'tb_venda.id_venda_vda', '=', 'rel_venda_material.id_venda_rvm')
            ->where('tb_venda.is_deleted', 0)
            ->groupBy('tb_venda.id_venda_vda', 'tb_venda.id_funcionario_vda', 'tb_funcionarios.desc_funcionario_tfu')
            ->orderBy('id_venda_vda', 'desc')
            ->get();

        if ($filtros)
        {
            $data = $data->where($filtros);
        }

        if ($id)
        {
            $data = $data->where('tb_venda.id_venda_vda', $id);
        }

        return $data;
    }

    public static function deleteReg($id_venda)
    {
        Venda::where('id_venda_vda', $id_venda)
            ->update([
                'is_deleted' => 1
            ]);
    }
}
