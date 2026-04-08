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
        Schema::create('kurir', function (Blueprint $table) {
            $table->bigIncrements('id_kurir');
            $table->string('nama_kurir', 120);
            $table->string('no_telp', 20)->unique();
            $table->enum('jenis_kendaraan', ['motor', 'mobil']);
            $table->string('plat_kendaraan', 20)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('catatan', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurir');
    }
};
