<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
     
    protected $table = "tb_material";

    protected $fillable = [
        'des_material_mte',
        'is_ativo_mte'
    ];

    public static function getAll() {
        $data = Material::select(['*'])->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {    
        if($id) {
            $data = Material::select(['*'])->where('id_material_mte', $id)->get();
        }else{
            $data = Material::select(['*'])->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_material, $obj) {
        Material::where('id_material_mte', $id_material)
        ->update([
            'des_material_mte' => $obj->des_material_mte
        ]);
    }

    public static function deleteReg($id_material) {
        Material::where('id_material_mte', $id_material)
        ->update([
            'is_ativo_mte' => 0
        ]);
    }

}
