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
        Schema::create('rating_seafoods', function (Blueprint $table) {
            $table->id();
            $table->String('seafood_id');
            $table->unsignedTinyInteger('rating')->comment('Rating dari 1 sampai 5'); // Nilai rating (1-5)
            $table->text('review')->nullable()->comment('Review dari pengguna'); // Opsional review
            $table->timestamps();
            $table->foreign('seafood_id')->references('kode_seafood')->on('seafoods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_seafoods');
    }
};
