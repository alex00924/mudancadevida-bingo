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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('quantity')->default(1);
            $table->string('price');
            $table->integer('payment_status')->default(0); // 0: pending, 1: success, 2: fail
            $table->string('payment_id');
            $table->string('qr_code');
            $table->text('qr_code_base64');
            $table->string('ticket_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
