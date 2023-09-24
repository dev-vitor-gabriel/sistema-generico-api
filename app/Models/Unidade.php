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
        'is_ativo_und'
    ];

    public static function getAll() {
        $data = Unidade::select(['*'])->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {    
        if($id) {
            $data = Unidade::select(['*'])->where('id_unidade_und', $id)->get();
        }else{
            $data = Unidade::select(['*'])->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_unidade_und, $obj) {
        Unidade::where('id_unidade_und', $id_unidade_und)
        ->update([
            'des_unidade_und' => $obj->des_unidade_und,
        ]);
    }

    public static function deleteReg($id_unidade_und) {
        Unidade::where('id_unidade_und', $id_unidade_und)
        ->update([
            'is_ativo_und' => 0
        ]);
    }
}
