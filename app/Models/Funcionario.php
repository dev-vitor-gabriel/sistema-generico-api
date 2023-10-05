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
        'endereco_funcionario_tfu'
    ];

    public static function getAll() {
        $data = Funcionario::select(['*'])->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {    
        if($id) {
            $data = Funcionario::select(['*'])->where('id_funcionario_tfu', $id)->get();
        }else{
            $data = Funcionario::select(['*'])->get();
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
