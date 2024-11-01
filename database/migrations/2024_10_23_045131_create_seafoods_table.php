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
        Schema::create('seafoods', function (Blueprint $table) {
            $table->string('kode_seafood')->primary();
            $table->tinyText('nama');
            $table->tinyText('jenis_seafood');
            $table->integer('jumlah');
            $table->string('foto');
            $table->unsignedBigInteger('nelayan_id');
            $table->tinyText('status')->nullable();
            $table->timestamps();
            $table->foreign('nelayan_id')->references('id')->on('nelayans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seafoods');
    }
};
