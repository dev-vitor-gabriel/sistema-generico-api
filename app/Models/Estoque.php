<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;
    protected $table = "tb_estoque";

    protected $fillable = [
        'des_estoque_est',
        'is_ativo_est'
    ];

    public static function getAll() {
        $data = Estoque::select(['*'])->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {    
        if($id) {
            $data = Estoque::select(['*'])->where('id_estoque_est', $id)->get();
        }else{
            $data = Estoque::select(['*'])->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_estoque, $obj) {
        Estoque::where('id_estoque_est', $id_estoque)
        ->update([
            'des_estoque_est' => $obj->des_estoque_est
        ]);
    }

    public static function deleteReg($id_estoque) {
        Estoque::where('id_estoque_est', $id_estoque)
        ->update([
            'is_ativo_est' => 0
        ]);
    }
}
