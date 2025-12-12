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
        Schema::create('payments', function (Blueprint $table) {
    $table->id();

    $table->foreignId('booking_id')
          ->constrained('bookings')
          ->cascadeOnDelete();

    // system fields
    $table->integer('amount');
    $table->string('method')->nullable();

    // midtrans
    $table->string('order_id');
    $table->string('midtrans_transaction_id')->nullable();
    $table->string('payment_type')->nullable();
    $table->string('fraud_status')->nullable();
    $table->string('va_number')->nullable();
    $table->dateTime('settlement_time')->nullable();

    $table->string('snap_token')->nullable();
    $table->string('payment_url')->nullable();

    // recommended additions
    $table->string('transaction_status')->nullable(); // midtrans status (pending/settlement/expire)
    $table->string('failure_reason')->nullable();     // jika "deny" atau "failed"

    // refund fields
    $table->integer('refund_amount')->nullable();
    $table->string('refund_reason')->nullable();
    $table->timestamp('refund_time')->nullable();

    $table->enum('status', ['pending','success','failed','refund','refunded'])
          ->default('pending');

    $table->dateTime('paid_at')->nullable();
    $table->timestamp('expiry_time')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
