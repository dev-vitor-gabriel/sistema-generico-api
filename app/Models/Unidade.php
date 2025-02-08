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
        'id_empresa_und',
        'is_ativo_und'
    ];

    public static function getAll($id_empresa) {
        $data = Unidade::
        select(['*'])
        ->where('is_ativo_und', 1)
        ->where('id_empresa_und', $id_empresa)
        ->orderBy('id_unidade_und', 'desc')
        ->get();
        return response()->json($data);
    }

    public static function getById(Int $id_empresa, Int $id = null) {
        if($id) {
            $data = Unidade::
            select(['*'])
            ->where('id_unidade_und', $id)
            ->where('is_ativo_und', 1)
            ->where('id_empresa_und', $id_empresa)
            ->orderBy('id_unidade_und', 'desc')
            ->get();
        }else{
            $data = Unidade::
            select(['*'])
            ->where('is_ativo_und', 1)
            ->where('id_empresa_und', $id_empresa)
            ->orderBy('id_unidade_und', 'desc')
            ->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_empresa, Int $id_unidade_und, $obj) {
        Unidade::
        where('id_unidade_und', $id_unidade_und)
        ->where('id_empresa_und', $id_empresa)
        ->update([
            'des_unidade_und'       => $obj->des_unidade_und,
            'des_reduz_unidade_und' => $obj->des_reduz_unidade_und
        ]);
    }

    public static function deleteReg($id_empresa, $id_unidade_und) {
        Unidade::
        where('id_unidade_und', $id_unidade_und)
        ->where('id_empresa_und', $id_empresa)
        ->update([
            'is_ativo_und' => 0
        ]);
    }
}
