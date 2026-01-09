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
        Schema::create('counselors', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->constrained('users')
              ->cascadeOnDelete();

        $table->string('education');
        $table->string('specialization');
        $table->text('description');
        $table->integer('price_per_session');
        $table->integer('online_price_per_session');

        $table->enum('status', ['active', 'inactive'])
              ->default('active');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselors');
    }
};
