<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelEmpresaMenu extends Model
{
    use HasFactory;

    protected $table = 'rel_empresa_menu';

    protected $fillable = [
        'id_empresa_emn',
        'id_menu_emn'
    ];

    public static function getMenuByIdEmpresa(Int $id_empresa){
        $menus = RelEmpresaMenu::where('id_empresa_emn', $id_empresa)
        ->join('tb_menu as tm', 'rel_empresa_menu.id_menu_emn', '=', 'tm.id_menu_mnu')
        ->select([
            'tm.des_menu_mnu',
            'tm.icon_menu_mnu',
            'tm.id_father_mnu',
            'tm.id_menu_mnu',
            'tm.path_menu_mnu'
        ])
        ->get();

        return $menus;
    }
}
