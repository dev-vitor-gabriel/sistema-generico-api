<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelVendaMaterial extends Model
{
    use HasFactory;

    protected $table = 'rel_venda_material';

    protected $fillable = [
        'id_material_rvm',
        'id_venda_rvm',
        'vlr_unit_material_rvm',
        'qtd_material_rvm'
    ];
}
