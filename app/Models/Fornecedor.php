<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = "tb_fornecedor";

    protected $fillable = [
        'desc_fornecedor_frn',
        'tel_fornecedor_frn',
        'documento_fornecedor_frn',
        'is_ativo_frn'
    ];

    public static function getAll(){
        $data = Fornecedor::select(['*'])->where('is_ativo_frn', 1)->ordeBy('id_fornecedor_frn', 'desc')->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null){
        if($id){
            $data = Fornecedor::select(['*'])->where('id_fornecedor_frn', $id)->where('is_ativo_frn', 1)->get();
            return response()->json($data);
       }else{
            $data = Fornecedor::getAll();
       }

       return $data;
    }

    public static function updataReg(Int $id_fornecedor, $obj) {
        Fornecedor::where('id_fornecedor_frn', $id_fornecedor)
        ->update([
            'desc_fornecedor_frn'       => $obj->desc_fornecedor_frn,
            'tel_fornecedor_frn'        => $obj->tel_fornecedor_frn,
            'documento_fornecedor_frn'  => $obj->documento_fornecedor_frn

        ]);
    }
    
    public static function deleteReg($id_fornecedor) {
        Fornecedor::where('id_fornecedor_frn', $id_fornecedor)
        ->update([
            'is_ativo_frn' => 0
        ]);
    }

}
