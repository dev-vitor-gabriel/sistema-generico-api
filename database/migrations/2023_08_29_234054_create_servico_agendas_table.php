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
        Schema::create('tb_servico_agenda', function (Blueprint $table) {
            $table->id('id_agenda_age');
            $table->dateTime('dth_agenda_age');
            $table->integer('id_servico_age');
            $table->boolean('is_ativo_age');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_servico_agenda');
    }
};
