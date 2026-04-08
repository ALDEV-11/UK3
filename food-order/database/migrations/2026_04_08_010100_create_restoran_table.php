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
        Schema::create('restoran', function (Blueprint $table) {
            $table->bigIncrements('id_restoran');
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete();
            $table->string('nama_restoran', 150);
            $table->string('slug', 160)->unique();
            $table->text('deskripsi')->nullable();
            $table->text('alamat');
            $table->string('no_telp', 15);
            $table->string('gambar', 255)->nullable();
            $table->time('jam_buka');
            $table->time('jam_tutup');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restoran');
    }
};
