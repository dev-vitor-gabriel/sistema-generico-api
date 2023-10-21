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
        Schema::create('tb_auditoria', function (Blueprint $table) {
            $table->id('id_auditoria_aud');
            $table->integer('id_externo_aud');
            $table->string('des_tabela_aud', 100);
            $table->jsonb('json_original_aud')->nullable();
            $table->jsonb('json_alteracao_aud');
            $table->timestamp('dth_cadastro_aud');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_auditoria');
    }
};
