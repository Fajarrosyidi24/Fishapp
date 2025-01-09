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
        Schema::create('pengembalian_barangs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('jam_pengembalian');
            $table->decimal('denda', 10, 2);
            $table->string('status_pengembalian');
            $table->unsignedBigInteger('tb_pesanan_sewa_id');
            $table->timestamps();
            $table->foreign('tb_pesanan_sewa_id')->references('id')->on('pesanan_barang_sewas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian_barangs');
    }
};
