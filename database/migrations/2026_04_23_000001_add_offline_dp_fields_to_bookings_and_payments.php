<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('payment_scheme')->default('full')->after('consultation_type');
            $table->unsignedInteger('down_payment_percentage')->nullable()->after('payment_scheme');
            $table->unsignedBigInteger('down_payment_amount')->nullable()->after('down_payment_percentage');
            $table->unsignedBigInteger('remaining_amount')->nullable()->after('down_payment_amount');
            $table->timestamp('settled_at')->nullable()->after('remaining_amount');
            $table->foreignId('settled_by_admin_id')->nullable()->after('settled_at')->constrained('users')->nullOnDelete();
        });

        DB::statement("ALTER TABLE bookings MODIFY status ENUM('pending_payment', 'paid', 'dp_paid', 'cancelled', 'completed', 'rescheduled') NOT NULL");
        DB::statement("ALTER TABLE payments MODIFY status ENUM('pending','success','partial','failed','refund','refunded') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE payments MODIFY status ENUM('pending','success','failed','refund','refunded') NOT NULL DEFAULT 'pending'");
        DB::statement("ALTER TABLE bookings MODIFY status ENUM('pending_payment', 'paid', 'cancelled', 'completed', 'rescheduled') NOT NULL");

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('settled_by_admin_id');
            $table->dropColumn([
                'payment_scheme',
                'down_payment_percentage',
                'down_payment_amount',
                'remaining_amount',
                'settled_at',
            ]);
        });
    }
};
