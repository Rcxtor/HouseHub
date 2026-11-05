<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('renter_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->date('move_in_date');

            $table->unsignedSmallInteger('occupant_count')->default(1);

            $table->text('message')->nullable();

            // pending, approved, rejected, withdrawn
            $table->string('status', 30)->default('pending');

            $table->timestamps();

            $table->index(['property_id', 'status']);
            $table->index(['renter_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_applications');
    }
};