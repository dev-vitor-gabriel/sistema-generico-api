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
        'id_centro_custo_mte',
        'is_ativo_mte',
        'id_empresa_mte',
    ];

    public static function getAll($id_empresa)
    {
        $data = Material::select([
            'tb_material.id_material_mte',
            'tb_material.des_material_mte',
            'tb_material.vlr_material_mte',
            'tb_unidade.des_reduz_unidade_und',
            'tb_material.is_ativo_mte',
            'tb_material.created_at',
            'tb_material.updated_at',
            'tb_centro_custo.des_centro_custo_cco'
        ])
            ->join('tb_unidade', 'tb_unidade.id_unidade_und', '=', 'tb_material.id_unidade_mte')
            ->leftjoin('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_material.id_centro_custo_mte')
            ->where('is_ativo_mte', 1)
            ->where('tb_material.id_empresa_mte', $id_empresa)
            ->orderBy('id_material_mte', 'desc')
            ->get();
        return response()->json($data);
    }

    public static function getById(Int $id_material,Int $id_empresa)
    {
         $data = Material::select(
            'tb_material.id_material_mte',
            'tb_material.des_material_mte',
            'tb_material.vlr_material_mte',
            'tb_unidade.des_reduz_unidade_und',
            'tb_material.is_ativo_mte',
            'tb_material.created_at',
            'tb_material.updated_at',
            'tb_centro_custo.des_centro_custo_cco'
            )
            ->join('tb_unidade', 'tb_unidade.id_unidade_und', '=', 'tb_material.id_unidade_mte')
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_material.id_centro_custo_mte')
            ->where('id_material_mte', $id_material)
            ->where('is_ativo_mte', 1)
            ->where('tb_material.id_empresa_mte', $id_empresa)
            ->first();
            return $data;
        
    }

    public static function updateReg(Int $id_empresa, Int $id_material, $dados_atualizados)
    {
        Material::where('id_material_mte', $id_material)
            ->where('id_empresa_mte', $id_empresa)
            ->update($dados_atualizados);
    }

    public static function deleteReg($id_empresa, $id_material)
    {
        Material::where('id_material_mte', $id_material)
            ->where('id_empresa_mte', $id_empresa)
            ->update([
                'is_ativo_mte' => 0
            ]);
    }
}
