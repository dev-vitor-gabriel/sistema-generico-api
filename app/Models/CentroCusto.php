<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroCusto extends Model
{
    use HasFactory;

    protected $table = "tb_centro_custo";

    protected $fillable = [
        'des_centro_custo_cco'
    ];

    public static function getAll() {
        $data = CentroCusto::select(['*'])->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {    
        if($id) {
            $data = CentroCusto::select(['*'])->where('id_centro_custo_cco', $id)->get();
        }else{
            $data = CentroCusto::select(['*'])->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_centro_custo, $obj) {
        CentroCusto::where('id_centro_custo_cco', $id_centro_custo)
        ->update([
            'des_centro_custo_cco' => $obj->des_centro_custo_cco
        ]);
    }

    public static function deleteReg($id_cliente) {
        CentroCusto::where('id_centro_custo_cco', $id_cliente)
        ->update([
            'is_ativo_cco' => 0
        ]);
    }

}
