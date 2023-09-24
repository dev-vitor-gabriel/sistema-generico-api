<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = "tb_material";

    protected $fillable = [
        'id_unidade_mte',
        'des_material_mte',
        'vlr_material_mte',
        'is_ativo_mte'
    ];

    public static function getAll()
    {
        $data = Material::select([
            'tb_material.id_material_mte',
            'tb_material.des_material_mte',
            'tb_material.vlr_material_mte',
            'tb_unidade.des_reduz_unidade_und',
            'tb_material.is_ativo_mte',
            'tb_material.created_at',
            'tb_material.updated_at'
        ])
            ->join('tb_unidade', 'tb_unidade.id_unidade_und', '=', 'tb_material.id_unidade_mte')
            ->where('is_ativo_mte', 1)
            ->orderBy('id_material_mte', 'desc')
            ->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null)
    {
        if ($id) {
            $data = Material::select([
                'tb_material.id_material_mte',
                'tb_material.des_material_mte',
                'tb_material.vlr_material_mte',
                'tb_unidade.des_reduz_unidade_und',
                'tb_material.is_ativo_mte',
                'tb_material.created_at',
                'tb_material.updated_at'
            ])
                ->join('tb_unidade', 'tb_unidade.id_unidade_und', '=', 'tb_material.id_unidade_mte')
                ->where('id_material_mte', $id)
                ->where('is_ativo_mte', 1)
                ->get();
            return response()->json($data);
        } else {
            $data = Material::select([
                'tb_material.id_material_mte',
                'tb_material.des_material_mte',
                'tb_material.vlr_material_mte',
                'tb_unidade.des_reduz_unidade_und',
                'tb_material.is_ativo_mte',
                'tb_material.created_at',
                'tb_material.updated_at'
            ])
                ->join('tb_unidade', 'tb_unidade.id_unidade_und', '=', 'tb_material.id_unidade_mte')
                ->where('is_ativo_mte', 1)
                ->orderBy('id_material_mte', 'desc')
                ->get();
            return response()->json($data);
        }
    }

    public static function updateReg(Int $id_material, $obj)
    {
        Material::where('id_material_mte', $id_material)
            ->update([
                'des_material_mte' => $obj->des_material_mte
            ]);
    }

    public static function deleteReg($id_material)
    {
        Material::where('id_material_mte', $id_material)
            ->update([
                'is_ativo_mte' => 0
            ]);
    }
}
