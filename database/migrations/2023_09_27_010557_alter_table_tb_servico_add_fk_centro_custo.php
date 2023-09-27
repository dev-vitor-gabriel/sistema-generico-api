<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_servico', function (Blueprint $table) {
            $table->unsignedBigInteger('id_centro_custo_cco');
            $table->foreign('id_centro_custo_cco')->references('id_centro_custo_cco')->on('tb_centro_custo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_servico');
    }
};
