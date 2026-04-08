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
        Schema::create('pesanan_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_pesanan');
            $table->string('status', 50);
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('pesanan')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_log');
    }
};
