<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_menu')->insert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Home',
            'icon_menu_mnu' => 'icon_home.png',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 0,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Serviço',
            'icon_menu_mnu' => 'servico.png',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 1,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 2,
            'des_menu_mnu' => 'Novo',
            'icon_menu_mnu' => 'novo_servico.png',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 2,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 2,
            'des_menu_mnu' => 'Lista',
            'icon_menu_mnu' => 'lista_servico.png',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 3,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Almoxarifado',
            'icon_menu_mnu' => 'almoxarifado_servico.png',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 4,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 5,
            'des_menu_mnu' => 'Entrada',
            'icon_menu_mnu' => 'almoxarifado_servico.png',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 5,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 5,
            'des_menu_mnu' => 'Movimentações',
            'icon_menu_mnu' => 'almoxarifado_servico.png',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 6,
        ]);
    }
}
