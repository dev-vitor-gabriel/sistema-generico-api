<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SituacoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_situacao')->insert([
            'tbl_situacao_tsi'  => 'tb_servico',
            'desc_situacao_tsi'  => 'Aberto',
        ]);
        DB::table('tb_situacao')->insert([
            'tbl_situacao_tsi'  => 'tb_servico',
            'desc_situacao_tsi'  => 'Finalizado',
        ]);
    }
}
