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
        'is_ativo_cli',
        'id_empresa_cli',
    ];

    public static function getAll(Int $id_empresa) {
        $data = Cliente::select(['*'])
        ->where('is_ativo_cli', 1)
        ->where('id_empresa_cli', $id_empresa)
        ->orderBy('id_cliente_cli', 'desc')
        ->get();
        return response()
        ->json($data);
    }

    public static function getById(Int $id_empresa, Int $id = null) {
        if($id) {
            $data = Cliente::select(['*'])
            ->where('id_cliente_cli', $id)
            ->where('id_empresa_cli', $id_empresa)
            ->where('is_ativo_cli', 1)
            ->orderBy('id_cliente_cli', 'desc')
            ->get();
        }else{
            $data = Cliente::select(['*'])
            ->where('is_ativo_cli', 1)
            ->where('id_empresa_cli', $id_empresa)
            ->orderBy('id_cliente_cli', 'desc')
            ->get();
        }
        return response()
        ->json($data);
    }

    public static function updateReg(Int $id_empresa, Int $id_cliente, $obj) {
        Cliente::
        where('id_cliente_cli', $id_cliente)
        ->where('id_empresa_cli', $id_empresa)
        ->update([
            'des_cliente_cli'       => $obj->des_cliente_cli,
            'telefone_cliente_cli'  => $obj->telefone_cliente_cli,
            'email_cliente_cli'     => $obj->email_cliente_cli,
            'documento_cliente_cli' => $obj->documento_cliente_cli,
            'endereco_cliente_cli'  => $obj->endereco_cliente_cli
        ]);
    }

    public static function deleteReg($id_empresa, $id_cliente) {
        Cliente::
        where('id_cliente_cli', $id_cliente)
        ->where('id_empresa_cli', $id_empresa)
        ->update([
            'is_ativo_cli' => 0
        ]);
    }

}
