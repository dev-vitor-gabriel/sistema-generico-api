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
        Schema::table('rel_venda_material', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estoque_item_eti');
            $table->foreign('id_estoque_item_eti')
            ->references('id_estoque_item_eti')
            ->on('tb_estoque_item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rel_venda_material', function (Blueprint $table) {
            $table->dropForeign(['id_estoque_item_eti']);
            $table->dropColumn('id_estoque_item_eti');
        });
    }
};
