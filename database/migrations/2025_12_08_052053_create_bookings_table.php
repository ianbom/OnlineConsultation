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

            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('counselor_id')->constrained('counselors')->cascadeOnDelete();

            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->foreignId('second_schedule_id')
                  ->nullable()
                  ->constrained('schedules')
                  ->nullOnDelete();

            $table->foreignId('previous_schedule_id')->nullable()->constrained('schedules')->nullOnDelete();
            $table->foreignId('previous_second_schedule_id')->nullable()->constrained('schedules')->nullOnDelete();

            $table->enum('reschedule_status', ['none', 'pending', 'approved', 'rejected'])->default('none');
            $table->text('reschedule_reason')->nullable();
            $table->enum('reschedule_by', ['client', 'counselor', 'admin'])->nullable();

            $table->integer('price');
            $table->integer('duration_hours');
            $table->enum('consultation_type', ['online','offline']);

            $table->string('meeting_link')->nullable();
            $table->enum('link_status', ['pending','sent'])->nullable();

            $table->enum('status', ['pending_payment', 'paid', 'cancelled', 'completed', 'rescheduled']);

            $table->text('notes')->nullable();
            $table->text('counselor_notes')->nullable();

            $table->enum('cancelled_by', ['client', 'counselor', 'admin', 'system'])->nullable();
            $table->text('cancel_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->enum('refund_status', ['none', 'requested', 'processed', 'done'])->default('none');
            $table->timestamp('refund_processed_at')->nullable();
            $table->boolean('is_expired')->default(false);

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
