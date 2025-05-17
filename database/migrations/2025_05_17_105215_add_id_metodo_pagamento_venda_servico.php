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
        Schema::table('tb_venda', function (Blueprint $table) {
            $table->unsignedBigInteger('id_metodo_pagamento_vda')->nullable()->after('id_status_vda');
            $table->foreign('id_metodo_pagamento_vda')
                ->references('id_metodo_pagamento_tmp')
                ->on('tb_metodo_pagamento')
                ->onDelete('restrict');
        });

        Schema::table('tb_servico', function (Blueprint $table) {
            $table->unsignedBigInteger('id_metodo_pagamento_ser')->nullable();
            $table->foreign('id_metodo_pagamento_ser')
                ->references('id_metodo_pagamento_tmp')
                ->on('tb_metodo_pagamento')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_venda', function (Blueprint $table) {
            $table->dropForeign(['id_metodo_pagamento_vda']);
            $table->dropColumn('id_metodo_pagamento_vda');
        });

        Schema::table('tb_servico', function (Blueprint $table) {
            $table->dropForeign(['id_metodo_pagamento_ser']);
            $table->dropColumn('id_metodo_pagamento_ser');
        });
    }
};
