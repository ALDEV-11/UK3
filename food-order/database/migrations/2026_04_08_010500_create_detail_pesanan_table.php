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
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->unsignedInteger('id_pesanan');
            $table->unsignedInteger('id_menu');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 10, 2);
            $table->text('catatan')->nullable();
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('pesanan')
                ->cascadeOnDelete();

            $table->foreign('id_menu')
                ->references('id_menu')
                ->on('menu')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
