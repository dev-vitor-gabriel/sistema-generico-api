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
        Schema::create('tb_servico', function (Blueprint $table) {
            $table->id('id_servico_ser');
            $table->string('des_servico_ser', 255);
            $table->longText('txt_servico_ser');
            $table->integer('vlr_servico_ser');
            $table->date('dta_agendamento_ser');
            $table->boolean('is_ativo_ser');
            $table->unsignedBigInteger('id_funcionario_servico_ser');
            $table->foreign('id_funcionario_servico_ser')->references('id_funcionario_tfu')->on('tb_funcionarios');
            $table->timestamps();
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
