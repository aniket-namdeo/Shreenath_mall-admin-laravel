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
        Schema::create('delivery_tracking_order', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_tracking_id');
            $table->string('order_id');
            $table->string('delivery_user_id');
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->string('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_tracking_order');
    }
};
