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
        Schema::create('nelayan_detail_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nelayan_id');
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('alamat_lengkap', 255);
            $table->string('provinsi', 30);
            $table->string('kabupaten', 30);
            $table->string('kecamatan', 50);
            $table->string('desa', 50);
            $table->string('dusun', 50);
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('code_pos', 5);
            $table->string('jenis_kelamin', 10); // Misalnya 'L' atau 'P'
            $table->string('no_telepon', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('nama_kapal', 100)->nullable();
            $table->string('jenis_kapal', 100)->nullable();
            $table->integer('jumlah_abk')->nullable();
            $table->string('foto')->nullable(); // Untuk menyimpan nama file foto
            $table->timestamps();
            $table->foreign('nelayan_id')->references('id')->on('nelayans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nelayan_detail_profiles');
    }
};
