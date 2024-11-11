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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat_lengkap', 255)->nullable();
            $table->string('provinsi', 30)->nullable();
            $table->string('kabupaten', 30)->nullable();
            $table->string('kecamatan', 50)->nullable();
            $table->string('desa', 50)->nullable();
            $table->string('dusun', 50)->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('code_pos', 5)->nullable();
            $table->string('jenis_kelamin', 10)->nullable();
            $table->string('no_telepon', 15)->nullable();
            $table->string('foto')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
