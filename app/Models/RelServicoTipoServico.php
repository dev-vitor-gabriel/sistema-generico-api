<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelServicoTipoServico extends Model
{
    use HasFactory;

    protected $table = 'rel_servico_tipo_servico';

    protected $fillable = [
        'id_servico_rst',
        'id_tipo_servico_rst',
        'vlr_tipo_servico_rst'
    ];
}
