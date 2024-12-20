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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('merchant_order_id')->unique();
            $table->decimal('payment_amount', 15, 2);
            $table->string('customer_va_name');
            $table->string('email');
            $table->string('phone_number');
            $table->json('item_details'); // Rincian barang (dalam format JSON)
            $table->json('customer_detail'); // Detail pelanggan (dalam format JSON)
            $table->string('callback_url'); // URL callback
            $table->string('return_url'); // URL redirect
            $table->integer('expiry_period'); // Periode kedaluwarsa dalam menit
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
