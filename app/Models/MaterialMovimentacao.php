<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialMovimentacao extends Model
{
    use HasFactory;
    protected $table = "tb_material_movimentacao";

    protected $fillable = [
        'txt_movimentacao_mov',
        'id_estoque_entrada_mov',
        'id_estoque_saida_mov',
        'id_centro_custo_mov',
        'is_ativo_mov'
    ];

    public static function get(Int $id = null) {    
        if($id) {
            $data = MaterialMovimentacao::select(['*'])->where('id_movimentacao_mov', $id)->get();
        }else{
            $data = MaterialMovimentacao::select(['*'])->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id, $obj) {
        MaterialMovimentacao::where('id_movimentacao_mov', $id)
        ->update([
            'txt_movimentacao_mov' => $obj->txt_movimentacao_mov
        ]);
    }

    public static function deleteReg($id) {
        MaterialMovimentacao::where('id_movimentacao_mov', $id)
        ->update([
            'is_ativo_mov' => 0
        ]);
    }
}
