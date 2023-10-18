<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
     
    protected $table = "tb_cliente";

    protected $fillable = [
        'des_cliente_cli',
        'telefone_cliente_cli',
        'email_cliente_cli',
        'documento_cliente_cli',
        'endereco_cliente_cli',
        'is_ativo_cli'
    ];

    public static function getAll() {
        $data = Cliente::select(['*'])->where('is_ativo_cli', 1)->orderBy('id_cliente_cli', 'desc')->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {    
        if($id) {
            $data = Cliente::select(['*'])->where('id_cliente_cli', $id)->where('is_ativo_cli', 1)->orderBy('id_cliente_cli', 'desc')->get();
        }else{
            $data = Cliente::select(['*'])->where('is_ativo_cli', 1)->orderBy('id_cliente_cli', 'desc')->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_cliente, $obj) {
        Cliente::where('id_cliente_cli', $id_cliente)
        ->update([
            'des_cliente_cli'       => $obj->des_cliente_cli,
            'telefone_cliente_cli'  => $obj->telefone_cliente_cli,
            'email_cliente_cli'     => $obj->email_cliente_cli,
            'documento_cliente_cli' => $obj->documento_cliente_cli,
            'endereco_cliente_cli'  => $obj->endereco_cliente_cli
        ]);
    }

    public static function deleteReg($id_cliente) {
        Cliente::where('id_cliente_cli', $id_cliente)
        ->update([
            'is_ativo_cli' => 0
        ]);
    }

}
