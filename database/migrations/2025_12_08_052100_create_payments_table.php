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
        $table->enum('method', ['bank_transfer','qris','ewallet']);

        // midtrans
        $table->string('order_id');
        $table->string('midtrans_transaction_id')->nullable();
        $table->string('payment_type')->nullable();
        $table->string('fraud_status')->nullable();
        $table->string('va_number')->nullable();
        $table->dateTime('settlement_time')->nullable();

        $table->string('snap_token')->nullable();
        $table->string('payment_url')->nullable();

        $table->enum('status', ['pending','success','failed','refund'])
              ->default('pending');

        $table->dateTime('paid_at')->nullable();

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
