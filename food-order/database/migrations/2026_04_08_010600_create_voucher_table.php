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
        Schema::create('voucher', function (Blueprint $table) {
            $table->increments('id_voucher');
            $table->string('kode_voucher', 20)->unique();
            $table->enum('jenis_diskon', ['persen', 'nominal']);
            $table->decimal('nilai_diskon', 10, 2);
            $table->decimal('min_pesanan', 12, 2);
            $table->decimal('maks_diskon', 10, 2);
            $table->integer('stok');
            $table->date('tgl_berlaku');
            $table->date('tgl_kadaluarsa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher');
    }
};
