<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $table = 'tb_servico';

    protected $fillable = [
        'des_servico_tipo_stp',
        'txt_servico_ser',
        'is_ativo_stp'
    ];


}
