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
        Schema::create('tb_material_movimentacao', function (Blueprint $table) {
            $table->id('id_movimentacao_mov');
            $table->longText('txt_movimentacao_mov');
            $table->integer('id_estoque_entrada_mov');
            $table->integer('id_estoque_saida_mov');
            $table->boolean('is_ativo_mov');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_material_movimentacao');
    }
};
