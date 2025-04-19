<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ValidateString;

class Pessoa extends Model
{
    use HasFactory;

    protected $table = "tb_pessoa";

    protected $fillable = [
        'nome_pessoa_pes',
        'id_centro_custo_pes',
        'documento_pessoa_pes'
    ];

    public static function getAll(){
        $data = Pessoa::select(['*'])->where('is_ativo_pes', 1)->orderBy('id_pessoa_pes', 'desc')->get();
        return response()->json($data);
    }

    public static function getById(Int $id_pessoa){
        
        $data = Pessoa::select(['*'])
        ->where('id_pessoa_pes', $id_pessoa)
        ->where('is_ativo_pes', 1)
        ->first();

        return $data;
    }

    public static function updateReg(Int $id_pessoa, $dados_atualizados) {
        Pessoa::where('id_pessoa_pes', $id_pessoa)
        ->update($dados_atualizados);
    }

    public static function deleteReg($id_pessoa){
        Pessoa::where('id_pessoa_pes', $id_pessoa)
        ->update([
            'is_ativo_pes' => 0
        ]);
    }
}
