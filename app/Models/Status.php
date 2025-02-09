<?php

namespace App\Models;

use App\Enums\OrigemStatusEnum;
use App\Enums\StatusVendaEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'origem_sts',
        'status_sts',
        'des_status_sts',
        'is_ativo',
    ];


    public static function getByOrigem(OrigemStatusEnum $origem)
    {
        $data = Status::
        where('origem_sts', $origem)
        ->get();
        return response()->json($data);
    }

    public static function getById(Int $id_status)
    {
        return Status::
        where('id_status_sts', $id_status)
        ->get();
    }

}
