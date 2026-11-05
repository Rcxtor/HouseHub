<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'profile_photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_suspended' => 'boolean',
            'deactivated_at' => 'datetime',
        ];
    }

    // Roles
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withTimestamps();
    }

    // Owner profile
    public function ownerProfile(): HasOne
    {
        return $this->hasOne(OwnerProfile::class);
    }

    // Properties owned by this user
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    // Favorites
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteProperties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'favorites')
            ->withTimestamps();
    }

    // Short-term bookings
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'renter_id');
    }

    // Long-term rental applications
    public function rentalApplications(): HasMany
    {
        return $this->hasMany(RentalApplication::class, 'renter_id');
    }

    // Property visit requests
    public function propertyVisits(): HasMany
    {
        return $this->hasMany(PropertyVisit::class, 'renter_id');
    }

    // Conversations
    public function ownedConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'owner_id');
    }

    public function renterConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'renter_id');
    }

    // Messages sent
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Reviews written
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    // Reports
    public function submittedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function reportsAgainst(): HasMany
    {
        return $this->hasMany(Report::class, 'reported_user_id');
    }

    public function reviewedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'reviewed_by');
    }

    // Verification
    public function verificationRequests(): HasMany
    {
        return $this->hasMany(VerificationRequest::class);
    }

    public function reviewedVerificationRequests(): HasMany
    {
        return $this->hasMany(
            VerificationRequest::class,
            'reviewed_by'
        );
    }

    // Audit logs
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    // Role helper
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function assignRole(string $role): void
    {
        $roleModel = Role::where('name', $role)->firstOrFail();

        $this->roles()->syncWithoutDetaching([$roleModel->id]);
    }

    public function removeRole(string $role): void
    {
        $roleModel = Role::where('name', $role)->first();

        if ($roleModel) {
            $this->roles()->detach($roleModel->id);
        }
    }

    public function assignDefaultRole(): void
    {
        $this->assignRole('renter');
    }
}
