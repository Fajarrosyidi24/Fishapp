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
        Schema::create('pesanan_seafoods', function (Blueprint $table) {
            $table->id();
            $table->decimal('subtotal_harga', 10, 2);
            $table->integer('jumlah_item');
            $table->decimal('ongkir', 10, 2);
            $table->decimal('total_keseluruhan_harga', 10, 2);
            $table->tinyText('metode_pembayaran');
            $table->tinyText('status');
            $table->tinyText('opsi_pengiriman');
            $table->tinyText('alamat_pengiriman');
            $table->tinyText('snap_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_seafoods');
    }
};
