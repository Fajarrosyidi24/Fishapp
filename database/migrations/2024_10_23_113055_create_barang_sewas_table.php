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
        Schema::create('barang_sewas', function (Blueprint $table) {
            $table->string('kode_barang')->primary();
            $table->string('nama_barang');
            $table->string('kondisi');
            $table->string('status');
            $table->integer('jumlah');
            $table->string('foto_barang');
            $table->unsignedBigInteger('nelayan_id');
            $table->timestamps();
            $table->foreign('nelayan_id')->references('id')->on('nelayans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_sewas');
    }
};
