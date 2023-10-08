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
        Schema::create('tb_conta', function (Blueprint $table) {
            $table->id('id_conta_con');
            $table->integer('id_conta_tipo_con');
            $table->date('dta_conta_con');
            $table->integer('vlr_conta_con');
            $table->boolean('is_ativo_con')->default(true);
            $table->unsignedBigInteger('id_centro_custo_con');
            $table->foreign('id_centro_custo_con')->references('id_centro_custo_cco')->on('tb_centro_custo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_conta');
    }
};
