<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPagamento extends Model
{
    use HasFactory;

    protected $table = "tb_metodo_pagamento";

    protected $fillable = [
        'desc_metodo_pagamento_tmp'
    ];

    public static function getAll()
    {
        $data = MetodoPagamento::select(['*'])->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {    
        if($id) {
            $data = MetodoPagamento::select(['*'])->where('id_metodo_pagamento_tmp', $id)->get();
        }else{
            $data = MetodoPagamento::select(['*'])->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_metodo_pagamento, $obj)
    {
        MetodoPagamento::where('id_metodo_pagamento_tmp', $id_metodo_pagamento)
            ->update([
                'desc_metodo_pagamento_tmp' => $obj->desc_metodo_pagamento_tmp
            ]);
    }

    public static function deleteReg($id_metodo_pagamento)
    {
        MetodoPagamento::where('id_metodo_pagamento_tmp', $id_metodo_pagamento)
            ->update([
                'is_ativo_tmp' => 0
            ]);
    }
}
