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
        Schema::create('harga_barang_sewas', function (Blueprint $table) {
            $table->string('kode_harga')->primary();
            $table->decimal('harga', 10, 2);
            $table->String('barang_id');
            $table->timestamps();
            $table->foreign('barang_id')->references('kode_barang')->on('barang_sewas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harga_barang_sewas');
    }
};
