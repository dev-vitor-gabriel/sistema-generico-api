<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstoqueItem extends Model
{
    use HasFactory;

    protected $table = "tb_estoque_item";

    protected $fillable = [
        'id_material_eti',
        'id_empresa_eti',
        'id_estoque_eti',
        'id_centro_custo_eti',
        'qtd_estoque_item_eti',
    ];

    public static function getByEstoque(Int $id_empresa, Int $id_estoque, Int $per_page, Int $page_number) {
        $paginator = EstoqueItem::select(['*'])
        ->where('is_ativo_eti', 1)
        ->where('id_empresa_eti', $id_empresa)
        ->where('id_estoque_eti', $id_estoque)
        ->orderBy('id_estoque_item_eti', 'desc')
        ->paginate($per_page, ['*'], 'page', $page_number);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function get(Int $id_empresa, Int $id_estoque, Int $id_material, Int $id_centro_custo) {
        $data = EstoqueItem::select([
        'id_estoque_item_eti',
        'id_empresa_eti',
        'id_estoque_eti',
        'id_material_eti',
        'id_centro_custo_eti',
        'qtd_estoque_item_eti'
        ])
        ->where('is_ativo_eti', 1)
        ->where('id_empresa_eti', $id_empresa)
        ->where('id_estoque_eti', $id_estoque)
        ->where('id_material_eti', $id_material)
        ->where('id_centro_custo_eti', $id_centro_custo);

        return $data->first();
    }

    public static function deleteReg($id_empresa, $id_estoque_item_eti) {
        EstoqueItem::
        where('id_estoque_item_eti', $id_estoque_item_eti)
        ->where('id_empresa_eti', $id_empresa)
        ->update([
            'is_ativo_eti' => 0
        ]);
    }

    public static function updateReg($id_empresa, $id_estoque_item_eti, $obj) {
        EstoqueItem::
        where('id_estoque_item_eti', $id_estoque_item_eti)
        ->where('id_empresa_eti', $id_empresa)
        ->update([
            'id_material_eti' => $obj->id_material_eti,
            'id_estoque_eti' => $obj->id_estoque_eti,
            'id_centro_custo_eti' => $obj->id_centro_custo_eti,
            'qtd_estoque_item_eti' => $obj->qtd_estoque_item_eti,
            'updated_at' => now(),
        ]);
    }

}
