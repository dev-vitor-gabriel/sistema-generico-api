<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicoTipo extends Model
{
    use HasFactory;

    protected $table = "tb_servico_tipo";

    protected $fillable = [
        'des_servico_tipo_stp',
        'vlr_servico_tipo_stp',
        'id_centro_custo_stp',
        'is_ativo_stp'
    ];

    public static function getAll() {
        $data = ServicoTipo::select('tb_servico_tipo.*', 'tb_centro_custo.des_centro_custo_cco')
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_servico_tipo.id_centro_custo_stp')
            ->where('tb_servico_tipo.is_ativo_stp', 1)
            ->orderBy('tb_servico_tipo.id_servico_tipo_stp', 'desc')
            ->get();
            
        return response()->json($data);
    }
    

    public static function getById(Int $id = null) {
        if($id) {
            $data = ServicoTipo::select('tb_servico_tipo.*', 'tb_centro_custo.des_centro_custo_cco')
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_servico_tipo.id_centro_custo_stp')
            ->where('id_servico_tipo_stp', $id)
            ->orderBy('id_servico_tipo_stp', 'desc')->get();
        }else{
            $data = ServicoTipo::select('tb_servico_tipo.*', 'tb_centro_custo.des_centro_custo_cco')
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_servico_tipo.id_centro_custo_stp')
            ->where('is_ativo_stp', 1)
            ->orderBy('id_servico_tipo_stp', 'desc')->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_tipo_servico, $obj) {
        ServicoTipo::where('id_servico_tipo_stp', $id_tipo_servico)
        ->update([
            'des_servico_tipo_stp' => $obj->des_servico_tipo_stp,
            'vlr_servico_tipo_stp' => $obj->vlr_servico_tipo_stp,
            'id_centro_custo_stp'  => $obj->id_centro_custo_stp
        ]);
    }

    public static function deleteReg($id_tipo_servico) {
        ServicoTipo::where('id_servico_tipo_stp', $id_tipo_servico)
        ->update([
            'is_ativo_stp' => 0
        ]);
    }

}