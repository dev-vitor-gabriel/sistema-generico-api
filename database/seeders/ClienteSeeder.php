<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_cliente')->insert([
            'des_cliente_cli'  => 'Cliente A',
            'telefone_cliente_cli'  => '85900000000',
        ]);
    }
}
