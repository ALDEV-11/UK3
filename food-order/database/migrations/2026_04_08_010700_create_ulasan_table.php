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
        Schema::create('ulasan', function (Blueprint $table) {
            $table->increments('id_ulasan');
            $table->unsignedInteger('id_pesanan');
            $table->unsignedBigInteger('id_pelanggan');
            $table->unsignedTinyInteger('rating_makanan');
            $table->unsignedTinyInteger('rating_pengiriman');
            $table->text('komentar')->nullable();
            $table->dateTime('tanggal');
            $table->timestamps();

            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('pesanan')
                ->cascadeOnDelete();

            $table->foreign('id_pelanggan')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
