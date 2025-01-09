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
        Schema::create('pesanan_barang_sewas', function (Blueprint $table) {
            $table->id();
            $table->decimal('subtotal_harga', 10, 2);
            $table->integer('jumlah_item');
            $table->decimal('total_keseluruhan_harga', 10, 2);
            $table->tinytext('status');
            $table->integer('jumlah_sewa');
            $table->integer('jumlah_waktu');
            $table->dateTime('jam_sewa');
            $table->dateTime('jam_pengembalian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_barang_sewas');
    }
};
