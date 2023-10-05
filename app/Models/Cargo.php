<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = "tb_cargos";

    protected $fillable = [
        'desc_cargo_tcg'
    ];

    public static function getAll() {
        $data = Cargo::select(['*'])->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {    
        if($id) {
            $data = Cargo::select(['*'])->where('id_cargo_tcg', $id)->get();
        }else{
            $data = Cargo::select(['*'])->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_cargo, $obj) {
        Cargo::where('id_cargo_tcg', $id_cargo)
        ->update([
            'desc_cargo_tcg' => $obj->desc_cargo_tcg
        ]);
    }

    public static function deleteReg($id_cargo) {
        Cargo::where('id_cargo_tcg', $id_cargo)
        ->update([
            'is_ativo_tcg' => 0
        ]);
    }

}
