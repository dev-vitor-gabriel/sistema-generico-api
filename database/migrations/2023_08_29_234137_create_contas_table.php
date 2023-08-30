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
            $table->integer('vlr_conta_ser');
            $table->boolean('is_ativo_con');
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
