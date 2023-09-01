<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicoTipo extends Model
{
    use HasFactory;
    
    protected $table = "tb_servico_tipo";

    protected $fillable = [
        'des_servico_tipo_stp',
        'is_ativo_stp'
    ];
}
