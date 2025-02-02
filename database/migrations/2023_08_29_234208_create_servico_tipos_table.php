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
        Schema::create('tb_servico_tipo', function (Blueprint $table) {
            $table->id('id_servico_tipo_stp');
            $table->unsignedBigInteger('id_centro_custo_stp');
            $table->string('des_servico_tipo_stp');
            $table->integer('vlr_servico_tipo_stp');
            $table->boolean('is_ativo_stp')->default(true);
            $table->foreign('id_centro_custo_stp')->references('id_centro_custo_cco')->on('tb_centro_custo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_servico_tipo');
    }
};
