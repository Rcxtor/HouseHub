<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalApplication extends Model
{
    protected $fillable = [
        'property_id',
        'renter_id',
        'move_in_date',
        'occupant_count',
        'message',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'move_in_date' => 'date',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function renter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'renter_id');
    }
}
