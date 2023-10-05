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
            'des_menu_mnu'  => 'Home',
            'icon_menu_mnu' => 'House',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 1,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Serviço',
            'icon_menu_mnu' => 'Scissors',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 2,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 2,
            'des_menu_mnu' => 'Novo Serviço',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 3,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 2,
            'des_menu_mnu' => 'Finalizar Serviço',
            'icon_menu_mnu' => 'CheckSquareOffset',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 4,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 2,
            'des_menu_mnu' => 'Relatório de Serviço',
            'icon_menu_mnu' => 'ChartLine',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 5,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Almoxarifado',
            'icon_menu_mnu' => 'DropboxLogo',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 6,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 6,
            'des_menu_mnu' => 'Consulta Estoque',
            'icon_menu_mnu' => 'MagnifyingGlass',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 7,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 6,
            'des_menu_mnu' => 'Baixa de Entrada',
            'icon_menu_mnu' => 'ArrowDown',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 8,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 6,
            'des_menu_mnu' => 'Baixa de Saída',
            'icon_menu_mnu' => 'ArrowUp',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 9,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 6,
            'des_menu_mnu' => 'Relatório de Movimentações',
            'icon_menu_mnu' => 'ChartLine',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 10,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Financeiro',
            'icon_menu_mnu' => 'Coins',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 11,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 11,
            'des_menu_mnu' => 'A Receber',
            'icon_menu_mnu' => 'ArrowDown',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 12,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 11,
            'des_menu_mnu' => 'A Pagar',
            'icon_menu_mnu' => 'ArrowUp',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 13,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 11,
            'des_menu_mnu' => 'Relatório Financeiro',
            'icon_menu_mnu' => 'ChartLine',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 14,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Cadastro Base',
            'icon_menu_mnu' => 'Gear',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 15,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 15,
            'des_menu_mnu' => 'Serviço',
            'icon_menu_mnu' => 'Scissors',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 16,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 16,
            'des_menu_mnu' => 'Cadastro de Tipo de Serviço',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 17,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 15,
            'des_menu_mnu' => 'Almoxarifado',
            'icon_menu_mnu' => 'DropboxLogo',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 18,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 18,
            'des_menu_mnu' => 'Cadastro de Unidade',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 19,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 18,
            'des_menu_mnu' => 'Cadastro de Materiais',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => 'cadastroMaterial',
            'num_ordem_mnu' => 20,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 18,
            'des_menu_mnu' => 'Cadastro de Estoque',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 21,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 15,
            'des_menu_mnu' => 'Financeiro',
            'icon_menu_mnu' => 'Coins',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 22,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 22,
            'des_menu_mnu' => 'Cadastro de método de Pagamento',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 23,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 22,
            'des_menu_mnu' => 'Cadastro de instituições de Pagamento',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 24,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 15,
            'des_menu_mnu' => 'USUÁRIOS',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 25,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 25,
            'des_menu_mnu' => 'Cadastro de Cargo',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 26,
        ]);
        DB::table('tb_menu')->insert([
            'id_father_mnu' => 25,
            'des_menu_mnu' => 'Cadastro de Funcionário',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 27,
        ]);
    }
}
