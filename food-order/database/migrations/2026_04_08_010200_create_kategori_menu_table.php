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
        Schema::create('kategori_menu', function (Blueprint $table) {
            $table->increments('id_kategori');
            $table->unsignedBigInteger('id_restoran');
            $table->string('nama_kategori', 100);
            $table->string('icon', 50)->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('kategori_menu');
    }
};
