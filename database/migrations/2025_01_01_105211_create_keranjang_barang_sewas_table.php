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
        Schema::create('keranjang_barang_sewas', function (Blueprint $table) {
            $table->string('kode_keranjang_sewa')->primary();
            $table->integer('jumlah');
            $table->decimal('subtotal', 10, 2);
            $table->tinyText('status');
            $table->String('barang_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('barang_id')->references('kode_barang')->on('barang_sewas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang_barang_sewas');
    }
};
