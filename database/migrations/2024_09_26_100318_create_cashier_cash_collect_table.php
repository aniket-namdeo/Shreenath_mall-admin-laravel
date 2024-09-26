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
        Schema::create('cashier_cash_collect', function (Blueprint $table) {
            $table->id();
            $table->integer('cashier_id');
            $table->integer('delivery_user_id');
            $table->float('collected_amount');
            $table->enum('collected_status', ['pending','collected']);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashier_cash_collect');
    }
};
