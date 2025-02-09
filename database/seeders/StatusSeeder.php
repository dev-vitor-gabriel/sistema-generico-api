<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_status_venda')->insert([
            'des_status_venda_svd' => 'Aberta',
            'is_ativo_svd' => true,
        ]);
        DB::table('tb_status_venda')->insert([
            'des_status_venda_svd' => 'Em processo',
            'is_ativo_svd' => true,
        ]);
        DB::table('tb_status_venda')->insert([
            'des_status_venda_svd' => 'Fechada',
            'is_ativo_svd' => true,
        ]);
    }
}
