<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RelUsuarioMenu extends Model
{
    use HasFactory;

    protected $table = 'rel_usuario_menu';

    protected $fillable = [
        'id_menu_usm',
        'id_user'
    ];
}
