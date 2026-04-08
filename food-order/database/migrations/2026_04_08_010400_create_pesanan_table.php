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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->increments('id_pesanan');
            $table->unsignedBigInteger('id_pelanggan');
            $table->unsignedBigInteger('id_restoran');
            $table->string('kode_pesanan', 25)->unique();
            $table->decimal('total_harga', 12, 2);
            $table->decimal('ongkir', 10, 2);
            $table->decimal('diskon', 10, 2)->default(0);
            $table->decimal('grand_total', 12, 2);
            $table->text('alamat_kirim');
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'dimasak', 'dikirim', 'selesai', 'batal'])->default('menunggu');
            $table->string('metode_bayar', 50);
            $table->dateTime('tanggal_pesan');
            $table->timestamps();

            $table->foreign('id_pelanggan')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('id_restoran')
                ->references('id_restoran')
                ->on('restoran')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
