<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;


    protected $table = 'tb_empresa';


    public static function findByCodigo($codigo) {
        $data = Empresa::select(['*'])->where('cod_empresa_emp', $codigo)->where('is_ativo_emp', 1)->get();
        return $data;
    }
}
