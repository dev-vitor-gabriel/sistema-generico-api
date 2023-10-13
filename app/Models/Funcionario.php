<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = "tb_funcionarios";

    protected $fillable = [
        'id_funcionario_cargo_tfu',
        'desc_funcionario_tfu',
        'telefone_funcionario_tfu',
        'documento_funcionario_tfu',
        'endereco_funcionario_tfu',
        'is_ativo_tfu'
    ];

    public static function getAll() {
        $data = $data = Funcionario::select([
            'id_funcionario_tfu',
            'desc_funcionario_tfu',
            'tb_cargos.desc_cargo_tcg',
            'tb_funcionarios.telefone_funcionario_tfu',
            'tb_funcionarios.documento_funcionario_tfu',
            'tb_funcionarios.endereco_funcionario_tfu',
            'tb_funcionarios.created_at',
            'tb_funcionarios.updated_at'])
            ->join('tb_cargos', 'tb_cargos.id_cargo_tcg', '=', 'tb_funcionarios.id_funcionario_cargo_tfu')
            ->where('is_ativo_tfu', 1)
            ->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {    
        if($id) {
            $data = Funcionario::select([
                'id_funcionario_tfu',
                'desc_funcionario_tfu',
                'tb_cargos.desc_cargo_tcg',
                'tb_funcionarios.telefone_funcionario_tfu',
                'tb_funcionarios.documento_funcionario_tfu',
                'tb_funcionarios.endereco_funcionario_tfu',
                'tb_funcionarios.created_at',
                'tb_funcionarios.updated_at'])
                ->join('tb_cargos', 'tb_cargos.id_cargo_tcg', '=', 'tb_funcionarios.id_funcionario_cargo_tfu')
                ->where('id_funcionario_tfu', $id)
                ->where('is_ativo_tfu', 1)
                ->get();
        }else{
            $data = Funcionario::select([
                'id_funcionario_tfu',
                'desc_funcionario_tfu',
                'tb_cargos.desc_cargo_tcg',
                'tb_funcionarios.telefone_funcionario_tfu',
                'tb_funcionarios.documento_funcionario_tfu',
                'tb_funcionarios.endereco_funcionario_tfu',
                'tb_funcionarios.created_at',
                'tb_funcionarios.updated_at'])
                ->join('tb_cargos', 'tb_cargos.id_cargo_tcg', '=', 'tb_funcionarios.id_funcionario_cargo_tfu')
                ->where('is_ativo_tfu', 1)
                ->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_funcionario, $obj) {
        Funcionario::where('id_funcionario_tfu', $id_funcionario)
        ->update([
            'id_funcionario_cargo_tfu' => $obj->id_funcionario_cargo_tfu,
            'desc_funcionario_tfu' => $obj->desc_funcionario_tfu,
            'telefone_funcionario_tfu' => $obj->telefone_funcionario_tfu,
            'documento_funcionario_tfu' => $obj->documento_funcionario_tfu,
            'endereco_funcionario_tfu' => $obj->endereco_funcionario_tfu,
        ]);
    }

    public static function deleteReg($id_funcionario) {
        Funcionario::where('id_funcionario_tfu', $id_funcionario)
        ->update([
            'is_ativo_tfu' => 0
        ]);
    }}
