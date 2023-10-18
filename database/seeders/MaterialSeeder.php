<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_material')->insert([
            'id_unidade_mte'=>1,
            'des_material_mte'=>'Material A',
            'vlr_material_mte'=>'1000',
        ]);
        DB::table('tb_material')->insert([
            'id_unidade_mte'=>1,
            'des_material_mte'=>'Material B',
            'vlr_material_mte'=>'1250',
        ]);
        DB::table('tb_material')->insert([
            'id_unidade_mte'=>1,
            'des_material_mte'=>'Material C',
            'vlr_material_mte'=>'2590',
        ]);
    }
}
