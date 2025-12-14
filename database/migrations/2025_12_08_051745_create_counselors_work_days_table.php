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
        Schema::create('counselors_work_days', function (Blueprint $table) {
        $table->id();

        $table->foreignId('counselor_id')
              ->constrained('counselors')
              ->cascadeOnDelete();

        $table->enum('day_of_week', [
            'monday','tuesday','wednesday','thursday','friday','saturday','sunday'
        ]);

        $table->time('start_time');
        $table->time('end_time');

        $table->boolean('is_active')->default(true);

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselors_work_days');
    }
};
