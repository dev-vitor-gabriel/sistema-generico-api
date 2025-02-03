<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;
    protected $table = "tb_unidade";

    protected $fillable = [
        'des_unidade_und',
        'des_reduz_unidade_und',
        'id_centro_custo_und',
        'is_ativo_und'
    ];

    public static function getAll() {
        $data = Unidade::select('tb_unidade.*', 'tb_centro_custo.des_centro_custo_cco')
        ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_unidade.id_centro_custo_und')
        ->where('is_ativo_und', 1)
        ->orderBy('id_unidade_und', 'desc')->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {
        if($id) {
            $data = Unidade::select('tb_unidade.*', 'tb_centro_custo.des_centro_custo_cco')
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_unidade.id_centro_custo_und')
            ->where('id_unidade_und', $id)
            ->where('is_ativo_und', 1)->orderBy('id_unidade_und', 'desc')->get();
        }else{
            $data = Unidade::select('tb_unidade.*', 'tb_centro_custo.des_centro_custo_cco')
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_unidade.id_centro_custo_und')
            ->where('is_ativo_und', 1)
            ->orderBy('id_unidade_und', 'desc')->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_unidade_und, $obj) {
        Unidade::where('id_unidade_und', $id_unidade_und)
        ->update([
            'des_unidade_und'       => $obj->des_unidade_und,
            'des_reduz_unidade_und' => $obj->des_reduz_unidade_und,
            'id_centro_custo_und'   => $obj->id_centro_custo_und,
        ]);
    }

    public static function deleteReg($id_unidade_und) {
        Unidade::where('id_unidade_und', $id_unidade_und)
        ->update([
            'is_ativo_und' => 0
        ]);
    }
}
