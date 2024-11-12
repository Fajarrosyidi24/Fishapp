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
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->string('kode_keranjang')->primary();
            $table->integer('jumlah');
            $table->decimal('subtotal', 10, 2);
            $table->tinyText('status');
            $table->String('seafood_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('seafood_id')->references('kode_seafood')->on('seafoods')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjangs');
    }
};
