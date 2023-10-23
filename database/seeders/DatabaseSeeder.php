<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CentroCusto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            EmpresaSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
            SituacoesSeeder::class,
            CargoSeeder::class,
            FuncionarioSeeder::class,
            UnidadeSeeder::class,
            MaterialSeeder::class,
            TipoServicoSeeder::class,
            CentroCustoSeeder::class,
            ContaTipoSeeder::class,
            ClienteSeeder::class,
        ]);
    }
}
