<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Property extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'property_type',
        'address',
        'area',
        'district',
        'division',
        'size_sqft',
        'bedrooms',
        'bathrooms',
        'balconies',
        'floor_number',
        'total_floors',
        'furnishing_status',
        'listing_status',
        'availability_status',
    ];

    // Property owner
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Images
    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(PropertyImage::class)
            ->where('is_primary', true);
    }

    // Amenities
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(
            Amenity::class,
            'property_amenities'
        );
    }

    // Rental configuration
    public function rentalDetail(): HasOne
    {
        return $this->hasOne(RentalDetail::class);
    }

    // Favorites
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    // Availability
    public function availability(): HasMany
    {
        return $this->hasMany(Availability::class);
    }

    // Short-term bookings
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Long-term applications
    public function rentalApplications(): HasMany
    {
        return $this->hasMany(RentalApplication::class);
    }

    // Property visits
    public function visits(): HasMany
    {
        return $this->hasMany(PropertyVisit::class);
    }

    // Conversations
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    // Reviews
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Reports
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    // Verification requests
    public function verificationRequests(): HasMany
    {
        return $this->hasMany(VerificationRequest::class);
    }
}
