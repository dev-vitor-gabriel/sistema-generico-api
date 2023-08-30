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
        Schema::create('tb_material_movimentacao_item', function (Blueprint $table) {
            $table->id('id_movimentacao_item_mit');
            $table->integer('id_movimentacao_mit');
            $table->integer('id_material_mit');
            $table->boolean('is_ativo_mit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_material_movimentacao_item');
    }
};
