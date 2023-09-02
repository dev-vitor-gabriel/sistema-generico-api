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

    // read all 
    public static function getAll() {
        $data = ServicoTipo::select(['*'])->get();
        return response()->json($data);
    }

    // read specific
    public static function getById(Int $id) {    
        $data = [];
        if($id) {
            $data = ServicoTipo::select(['*'])->where('id_servico_tipo_stp', $id)->get();
        }
        else {
            $data = ['message' => 'Error while fetching service type'];
        }
        return response()->json($data);
    }

    // update
    public static function updateServiceType($obj) {
        $data = [];
        ServicoTipo::where('id_servico_tipo_stp', $obj->id_servico_tipo_stp)
        ->update([
            'des_servico_tipo_stp' => $obj->des_servico_tipo_stp,
            'is_ativo_stp' => $obj->is_ativo_stp
        ]);

        $data = ['message' => 'Service type updated successfully'];

        return response()->json($data);
    }

    // delete (inactive)
    public static function deleteServiceType($obj) {
        $data = [];
        ServicoTipo::where('id_servico_tipo_stp', $obj)
        ->update([
            'is_ativo_stp' => 0
        ]);
        $data = ['message' => 'Service type inactivated successfully'];
        return response()->json($data);
    }



}
