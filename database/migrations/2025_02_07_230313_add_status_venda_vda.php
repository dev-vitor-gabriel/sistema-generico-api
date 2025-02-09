<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_venda', function (Blueprint $table){
            $table->unsignedBigInteger('id_status_venda_vda')->default(1);
            $table->foreign('id_status_venda_vda')
            ->references('id_status_venda_svd')
            ->on('tb_status_venda')
            ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_venda', function (Blueprint $table){
            $table->dropForeign('id_status_venda_vda');
            $table->dropColumn('id_status_venda_vda');
        });
    }
};
