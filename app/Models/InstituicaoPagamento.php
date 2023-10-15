<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituicaoPagamento extends Model
{
    use HasFactory;

    protected $table = "tb_instituicao_pagamento";

    protected $fillable = [
        'desc_instituicao_pagamento_tip',
        'is_ativo_tip'
    ];

    public static function getAll()
    {
        $data = InstituicaoPagamento::select(['*'])->where('is_ativo_tip', 1)->orderBy('id_instituicao_pagamento_tip', 'desc')->get();
        return response()->json($data);
    }

    public static function getById(Int $id = null) {
        if($id) {
            $data = InstituicaoPagamento::select(['*'])->where('desc_instituicao_pagamento_tip', $id)->where('is_ativo_tip', 1)->orderBy('id_instituicao_pagamento_tip', 'desc')->get();
        }else{
            $data = InstituicaoPagamento::select(['*'])->where('is_ativo_tip', 1)->orderBy('id_instituicao_pagamento_tip', 'desc')->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_instituicao_pagamento, $obj)
    {
        InstituicaoPagamento::where('id_instituicao_pagamento_tip', $id_instituicao_pagamento)
            ->update([
                'desc_instituicao_pagamento_tip' => $obj->desc_instituicao_pagamento_tip
            ]);
    }

    public static function deleteReg($id_instituicao_pagamento)
    {
        InstituicaoPagamento::where('id_instituicao_pagamento_tip', $id_instituicao_pagamento)
            ->update([
                'is_ativo_tip' => 0
            ]);
    }
}
