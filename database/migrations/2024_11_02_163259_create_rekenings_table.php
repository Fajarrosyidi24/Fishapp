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
        Schema::create('rekenings', function (Blueprint $table) {
            $table->string('kode_rekening')->primary();
            $table->tinyText('nomor_rekening');
            $table->tinyText('jenis_rekening');
            $table->tinyText('nama_akun_rekening');
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
        Schema::dropIfExists('rekenings');
    }
};
