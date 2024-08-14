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
        Schema::create('cash_deposit', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_user_id');
            $table->string('cash_amount');
            $table->string('deposit_amount');
            $table->string('deposit_date');
            $table->boolean('isVerified')->false;
            $table->string('status')->default(1);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_deposit');
    }
};
