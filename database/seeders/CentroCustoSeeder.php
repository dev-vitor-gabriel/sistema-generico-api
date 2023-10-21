<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentroCustoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_centro_custo')->insert([
            'des_centro_custo_cco'  => 'Salão G Beauty',
        ]);
        DB::table('tb_centro_custo')->insert([
            'des_centro_custo_cco'  => 'Salão G Barber',
        ]);
    }
}
