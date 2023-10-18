<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = "tb_cargos";

    protected $fillable = [
        'desc_cargo_tcg',
        'is_ativo_tcg'
    ];

    public static function getAll() {
        $data = Cargo::select(['*'])->where('is_ativo_tcg', 1)->orderBy('id_cargo_tcg', 'desc')->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {
        if($id) {
            $data = Cargo::select(['*'])->where('id_cargo_tcg', $id)->where('is_ativo_tcg', 1)->orderBy('id_cargo_tcg', 'desc')->get();
        }else{
            $data = Cargo::select(['*'])->where('is_ativo_tcg', 1)->orderBy('id_cargo_tcg', 'desc')->get();
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
