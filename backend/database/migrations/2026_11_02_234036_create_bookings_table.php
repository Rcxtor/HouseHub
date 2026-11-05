<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('renter_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->date('check_in');
            $table->date('check_out');

            $table->unsignedSmallInteger('guest_count')->default(1);

            // Preserve the price at the time of booking
            $table->decimal('nightly_price', 12, 2);
            $table->decimal('total_price', 12, 2);

            // pending, confirmed, cancelled, completed, rejected
            $table->string('status', 30)->default('pending');

            $table->timestamps();

            $table->index(['property_id', 'check_in', 'check_out']);
            $table->index(['renter_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};