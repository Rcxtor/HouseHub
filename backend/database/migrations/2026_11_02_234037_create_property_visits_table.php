<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_visits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('renter_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->dateTime('requested_at');

            $table->text('owner_note')->nullable();

            // pending, approved, rejected, cancelled, completed
            $table->string('status', 30)->default('pending');

            $table->timestamps();

            $table->index(['property_id', 'requested_at']);
            $table->index(['renter_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_visits');
    }
};