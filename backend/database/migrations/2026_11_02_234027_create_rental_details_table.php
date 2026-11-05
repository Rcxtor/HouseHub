<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            // short_term or long_term
            $table->string('rental_type', 30);

            // Rental price
            $table->decimal('price', 12, 2);
            $table->string('price_unit', 20);

            // Additional financial information
            $table->decimal('security_deposit', 12, 2)->nullable();
            $table->decimal('advance_amount', 12, 2)->nullable();

            $table->boolean('utility_included')->default(false);

            // Availability
            $table->date('available_from')->nullable();

            // Short-term rental settings
            $table->unsignedSmallInteger('minimum_nights')->nullable();
            $table->unsignedSmallInteger('maximum_nights')->nullable();
            $table->unsignedSmallInteger('guest_capacity')->nullable();

            $table->timestamps();

            $table->index('rental_type');
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_details');
    }
};