<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_unidade')->insert([
            'des_unidade_und'  => 'Unidade',
            'des_reduz_unidade_und'  => 'UN',
        ]);
        DB::table('tb_unidade')->insert([
            'des_unidade_und'  => 'Quilo',
            'des_reduz_unidade_und'  => 'Kg',
        ]);
        DB::table('tb_unidade')->insert([
            'des_unidade_und'  => 'Litros',
            'des_reduz_unidade_und'  => 'L',
        ]);
    }
}
