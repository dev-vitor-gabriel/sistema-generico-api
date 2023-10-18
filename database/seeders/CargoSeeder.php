<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_cargos')->insert([
            'desc_cargo_tcg'  => 'Barbeiro',
        ]);
        DB::table('tb_cargos')->insert([
            'desc_cargo_tcg'  => 'Cabeleireira',
        ]);
        DB::table('tb_cargos')->insert([
            'desc_cargo_tcg'  => 'Recepção',
        ]);
        
    }
}
