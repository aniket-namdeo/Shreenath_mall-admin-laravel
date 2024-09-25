<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->enum('delivery_status', ['pending', 'shipped', 'out_for_delivery', 'delivered'])->default('pending');
            $table->enum('payment_method', ['credit_card', 'debit_card', 'net_banking', 'wallet', 'cash_on_delivery']);
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->timestamp('order_date')->useCurrent();
            $table->timestamp('delivery_date')->nullable();
            $table->integer('address_id');
            $table->integer('pickup_otp')->nullable();
            $table->string('coupon_code', 50)->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('shipping_fee', 10, 2)->default(0.00);
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