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
        Schema::create('coupon', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code');
            $table->enum('offtype', ['percent', 'flat']);
            $table->decimal('min_purc_amount', 10, 2);
            $table->decimal('max_off_amount', 10, 2);
            $table->string('imageUrl');
            $table->date('expiry_date');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon');
    }
};
