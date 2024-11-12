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
    Schema::create('item_seafood_checkouts', function (Blueprint $table) {
    $table->id();
    $table->string('keranjang_id');
    $table->unsignedBigInteger('tb_pemesanan_id');
    $table->timestamps();

    $table->foreign('keranjang_id')->references('kode_keranjang')->on('keranjangs')->onDelete('cascade');
    $table->foreign('tb_pemesanan_id')->references('id')->on('pesanan_seafoods')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_seafood_checkouts');
    }
};
