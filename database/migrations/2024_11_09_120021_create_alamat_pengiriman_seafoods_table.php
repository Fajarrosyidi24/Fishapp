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
        Schema::create('alamat_pengiriman_seafoods', function (Blueprint $table) {
            $table->id();
            $table->tinyText('provid');
            $table->tinyText('cityid');
            $table->tinyText('provinsi');
            $table->tinyText('kabupaten');
            $table->tinyText('kecamatan');
            $table->tinyText('desa');
            $table->tinyText('dusun');
            $table->tinyText('rt');
            $table->tinyText('rw');
            $table->tinyText('code_pos');
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
        Schema::dropIfExists('alamat_pengiriman_seafoods');
    }
};
