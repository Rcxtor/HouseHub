<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            // Property owner
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Basic information
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->string('property_type', 50);

            // Location
            $table->string('address');
            $table->string('area', 100);
            $table->string('district', 100);
            $table->string('division', 100);

            // Property specifications
            $table->unsignedInteger('size_sqft')->nullable();
            $table->unsignedTinyInteger('bedrooms')->default(0);
            $table->unsignedTinyInteger('bathrooms')->default(0);
            $table->unsignedTinyInteger('balconies')->default(0);
            $table->unsignedSmallInteger('floor_number')->nullable();
            $table->unsignedSmallInteger('total_floors')->nullable();

            $table->string('furnishing_status', 30)->nullable();

            // Listing moderation status
            $table->string('listing_status', 30)->default('draft');

            // Actual rental availability
            $table->string('availability_status', 30)->default('available');

            $table->timestamps();

            // Indexes for common filters
            $table->index(['district', 'area']);
            $table->index('property_type');
            $table->index('listing_status');
            $table->index('availability_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};