<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Servico extends Model
{
    use HasFactory;

    protected $table = 'tb_servico';

    protected $fillable = [
        'txt_servico_ser',
        'vlr_servico_ser',
        'dta_agendamento_ser',
        'id_situacao_ser',
        'id_centro_custo_ser',
        'id_funcionario_servico_ser',
        'id_cliente_ser',
        'is_ativo_ser'
    ];

    public static function get(Int $id_servico = null, $filtros) {
        $data = Servico::select([
            'id_servico_ser'
            , 'txt_servico_ser'
            , 'vlr_servico_ser'
            , 'dta_agendamento_ser'
            , 'id_situacao_ser'
            , 'id_funcionario_servico_ser'
            , 'id_centro_custo_ser'
            , 'id_cliente_ser'
            , 'tb_servico.created_at'
            , 'id_material_mte'
            , 'des_material_mte'
            , 'des_reduz_unidade_und'
            , 'vlr_material_rsm'
            , 'qtd_material_rsm'
            , 'id_servico_tipo_stp'
            , 'des_servico_tipo_stp'
            , 'vlr_tipo_servico_rst'
        ])
        ->join('tb_funcionarios', 'id_funcionario_servico_ser', '=', 'id_funcionario_tfu')
        ->join('tb_cliente', 'id_cliente_ser', '=', 'id_cliente_cli')
        ->join('tb_situacao', 'id_situacao_ser', '=', 'id_situacao_tsi')
        ->leftJoin('rel_servico_tipo_servico', 'id_servico_ser', '=', 'id_servico_rst')
        ->leftJoin('tb_servico_tipo', 'id_tipo_servico_rst', '=', 'id_servico_tipo_stp')
        ->leftJoin('rel_servico_material', 'id_servico_ser', '=', 'id_servico_rsm')
        ->leftJoin('tb_material', 'id_material_rsm', '=', 'id_material_mte')
        ->leftJoin('tb_unidade', 'id_unidade_mte', '=', 'id_unidade_und');
        
        if($id_servico){
            $data = $data->where('id_servico_ser', $id_servico);
        }
        $data = $data->where($filtros);
        $data = $data->where('is_ativo_ser', 1);
        $data = $data->orderBy('id_servico_ser', 'desc')
        ->get();
        return $data;
    }

    // public static function getAll() {
    //     $data = Unidade::select(['*'])->where('is_ativo_ser', 1)->get();
    //     return response()->json($data);
    // }

    // public static function getById(Int $id = null) {
    //     if($id) {
    //         $data = Unidade::select(['*'])->where('id_servico_ser', $id)->where('is_ativo_ser', 1)->get();
    //     }else{
    //         $data = Unidade::select(['*'])->where('is_ativo_ser', 1)->get();
    //     }
    //     return response()->json($data);
    // }

    public static function updateReg(Int $id_servico, $obj) {
        Servico::where('id_servico_ser', $id_servico)
        ->update($obj);
    }

    public static function deleteReg($id_servico) {
        Servico::where('id_servico_ser', $id_servico)
        ->update([
            'is_ativo_ser' => 0
        ]);
    }


}
