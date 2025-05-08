<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financeiro extends Model
{
    use HasFactory;

    protected $table = "tb_financeiro";

    protected $primaryKey = 'id_financeiro_fin';

    protected $fillable = [
        'desc_financeiro_fin',
        'vlr_financeiro_fin',
        'tipo_transacao_fin',
        'id_empresa_fin',
        'id_referencia_fin',
        'tipo_referencia_fin',
        'is_ativo_fin',
    ];

}
