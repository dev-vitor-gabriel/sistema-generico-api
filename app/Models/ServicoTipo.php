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

    public static function getAll($id_empresa) {
        $data = ServicoTipo::select('tb_servico_tipo.*', 'tb_centro_custo.des_centro_custo_cco')
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_servico_tipo.id_centro_custo_stp')
            ->where('tb_servico_tipo.is_ativo_stp', 1)
            ->where('id_empresa_stp', $id_empresa)
            ->orderBy('tb_servico_tipo.id_servico_tipo_stp', 'desc')
            ->get();
      
            return response()->json($data);
    }
    

    public static function getById(Int $id_empresa, Int $id_tipo_servico) {
        
        $data = ServicoTipo::select('tb_servico_tipo.*', 'tb_centro_custo.des_centro_custo_cco')
        ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_servico_tipo.id_centro_custo_stp')
        ->where('id_servico_tipo_stp', $id_tipo_servico)
        ->where('id_empresa_stp', $id_empresa)
        ->where('is_ativo_stp', 1)
        ->first();
        
        return $data;
    }

    public static function updateReg(Int $id_empresa, Int $id_tipo_servico, $dados_atualizados) {
        ServicoTipo::where('id_servico_tipo_stp', $id_tipo_servico)
        ->where('id_empresa_stp', $id_empresa)
        ->update($dados_atualizados);
    }

    public static function deleteReg($id_empresa, $id_tipo_servico) {
        ServicoTipo::where('id_servico_tipo_stp', $id_tipo_servico)
        ->where('id_empresa_stp', $id_empresa)
        ->update([
            'is_ativo_stp' => 0
        ]);
    }

}
