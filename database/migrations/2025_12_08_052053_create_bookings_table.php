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
         Schema::create('bookings', function (Blueprint $table) {
        $table->id();

        $table->foreignId('client_id')
              ->constrained('users')
              ->cascadeOnDelete();

        $table->foreignId('counselor_id')
              ->constrained('counselors')
              ->cascadeOnDelete();

        $table->foreignId('schedule_id')
              ->constrained('schedules')
              ->cascadeOnDelete();

        $table->foreignId('previous_schedule_id')
              ->nullable()
              ->constrained('schedules')
              ->nullOnDelete();

        $table->integer('price'); // harga final
        $table->integer('duration_hours'); // 1 atau 2 jam

        $table->enum('consultation_type', ['online','offline']);

        $table->string('meeting_link')->nullable();

        $table->enum('link_status', ['pending','sent'])
              ->default('pending');

        $table->enum('status', [
            'pending_payment', 'paid', 'cancelled', 'completed', 'rescheduled'
        ]);

        $table->text('notes')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
