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

    public static function deleteReg($id)
    {
        RelVendaMaterial::where('id', $id)
            ->delete();
    }

    public static function updateReg(Int $id, $obj) {
        RelVendaMaterial::where('id', $id)
        ->update($obj);
    }

    public static function getByIdVenda(Int $id_venda) {
        $materiaisVenda = RelVendaMaterial::where('id_venda_rvm', $id_venda)->get();

        return $materiaisVenda->toArray();
    }
}
