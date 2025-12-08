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
        Schema::create('session_logs', function (Blueprint $table) {
        $table->id();

        $table->foreignId('booking_id')
              ->constrained('bookings')
              ->cascadeOnDelete();

        $table->text('counselor_notes')->nullable();

        $table->enum('session_status', [
            'completed', 'client_no_show', 'rescheduled'
        ]);

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_logs');
    }
};
