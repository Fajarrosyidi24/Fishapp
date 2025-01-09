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
        Schema::create('item_barang_sewas', function (Blueprint $table) {
            $table->id();
            $table->string('keranjang_sewa_id');
            $table->unsignedBigInteger('tb_pesanan_sewa_id');
            $table->timestamps();

            $table->foreign('keranjang_sewa_id')->references('kode_keranjang_sewa')->on('keranjang_barang_sewas')->onDelete('cascade');
            $table->foreign('tb_pesanan_sewa_id')->references('id')->on('pesanan_barang_sewas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_barang_sewas');
    }
};
