<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalDetail extends Model
{
    protected $fillable = [
        'property_id',
        'rental_type',
        'price',
        'price_unit',
        'security_deposit',
        'advance_amount',
        'utility_included',
        'available_from',
        'minimum_nights',
        'maximum_nights',
        'guest_capacity',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'security_deposit' => 'decimal:2',
            'advance_amount' => 'decimal:2',
            'utility_included' => 'boolean',
            'available_from' => 'date',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
