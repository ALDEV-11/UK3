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
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id_menu');
            $table->unsignedBigInteger('id_restoran');
            $table->unsignedInteger('id_kategori');
            $table->string('nama_menu', 150);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 10, 2);
            $table->string('gambar', 255)->nullable();
            $table->integer('stok')->default(0);
            $table->enum('status', ['tersedia', 'habis'])->default('tersedia');
            $table->timestamps();

            $table->foreign('id_restoran')
                ->references('id_restoran')
                ->on('restoran')
                ->cascadeOnDelete();

            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategori_menu')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
