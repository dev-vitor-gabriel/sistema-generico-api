<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function getAll() {
        $data = Unidade::select(['*'])->where('is_ativo_ser', 1)->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {
        if($id) {
            $data = Unidade::select(['*'])->where('id_servico_ser', $id)->where('is_ativo_ser', 1)->get();
        }else{
            $data = Unidade::select(['*'])->where('is_ativo_ser', 1)->get();
        }
        return response()->json($data);
    }

    // public static function updateReg(Int $id_servico, $obj) {
    //     Unidade::where('id_servico_ser', $id_servico)
    //     ->update([
    //         'des_servico_tipo_stp'       => $obj->des_unidade_und,
    //         'txt_servico_ser'            => $obj->des_reduz_unidade_und
    //     ]);
    // }

    public static function deleteReg($id_servico) {
        Unidade::where('id_servico_ser', $id_servico)
        ->update([
            'is_ativo_ser' => 0
        ]);
    }


}
