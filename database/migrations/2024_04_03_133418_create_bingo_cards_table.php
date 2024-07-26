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
        Schema::create('bingo_cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_number');
            $table->string('card_digit');
            $table->string("d1");
            $table->string("d2");
            $table->string("d3");
            $table->string("d4");
            $table->string("d5");
            $table->string("d6");
            $table->string("d7");
            $table->string("d8");
            $table->string("d9");
            $table->string("d10");
            $table->string("d11");
            $table->string("d12");
            $table->string("d13");
            $table->string("d14");
            $table->string("d15");
            $table->string("d16");
            $table->string("d17");
            $table->string("d18");
            $table->string("d19");
            $table->string("d20");
            $table->string("d21");
            $table->string("d22");
            $table->string("d23");
            $table->string("d24");
            $table->string("d25");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bingo_cards');
    }
};
