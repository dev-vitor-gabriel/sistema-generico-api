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

    public static function get(Int $id_servico = null, $filtros = null) {
        $data = Servico::select([
            'id_servico_ser'
            , 'txt_servico_ser'
            , 'vlr_servico_ser'
            , 'dta_agendamento_ser'
            , 'id_situacao_ser'
            , 'desc_situacao_tsi'
            , 'id_funcionario_servico_ser'
            , 'desc_funcionario_tfu'
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
        // ->ddRawSql();
        ->get();
        return $data;
    }
    public static function getLast30Days($request) {
        
        $data = Servico::selectRaw('COUNT(1) as qtd, DATE_FORMAT(dta_agendamento_ser, "%d/%m/%Y") as dta_agendamento')
        ->where('dta_agendamento_ser', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 30 DAY)'))
        ->where('id_situacao_ser', 2);
        if(isset($request->centrocusto) && !empty($request->centrocusto)){
            $centroCusto = explode(',', $request->centrocusto);
            $data = $data->whereIn('id_centro_custo_ser', $centroCusto);
        }
        $data = $data->groupBy('dta_agendamento')
        ->orderBy('dta_agendamento', 'ASC')
        // ->ddRawSql();
        ->get();
        return $data;
    }
    public static function getLast30DaysPerFunc($request = null) {
        
        $data = Servico::selectRaw('COUNT(1) as qtd, desc_funcionario_tfu')
        ->join('tb_funcionarios', 'id_funcionario_servico_ser', '=', 'id_funcionario_tfu')
        ->where('dta_agendamento_ser', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 30 DAY)'))
        ->where('id_situacao_ser', 2);
        if(isset($request->centrocusto) && !empty($request->centrocusto)){
            $centroCusto = explode(',', $request->centrocusto);
            $data = $data->whereIn('id_centro_custo_ser', $centroCusto);
        }
        $data = $data->groupBy('desc_funcionario_tfu')
        ->orderBy('qtd', 'DESC')
        // ->ddRawSql();
        ->get();

        return $data;
    }
    public static function getLast30DaysPerTipoServico($request) {
        
        $data = Servico::selectRaw('COUNT(1) as qtd, des_servico_tipo_stp')
        ->join('rel_servico_tipo_servico', 'id_servico_ser', '=', 'id_servico_rst')
        ->join('tb_servico_tipo', 'id_tipo_servico_rst', '=', 'id_servico_tipo_stp')
        ->where('dta_agendamento_ser', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 30 DAY)'))
        ->where('id_situacao_ser', 2);
        if(isset($request->centrocusto) && !empty($request->centrocusto)){
            $centroCusto = explode(',', $request->centrocusto);
            $data = $data->whereIn('id_centro_custo_ser', $centroCusto);
        }
        $data = $data->groupBy('des_servico_tipo_stp')
        ->orderBy('qtd', 'DESC')
        // ->ddRawSql();
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
    public static function finalizarReg($id_servico) {
        Servico::where('id_servico_ser', $id_servico)
        ->update([
            'id_situacao_ser' => 2
        ]);
    }


}
