<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    /**
     * Admins can perform any property action.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user && $user->hasRole('admin')) {
            return true;
        }

        return null;
    }
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Property $property): bool
    {
        return $property->listing_status === 'approved'
            || ($user !== null && $property->user_id === $user->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('owner');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Property $property): bool
    {
        return $property->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Property $property): bool
    {
        return $property->user_id === $user->id;
    }

    public function submit(User $user, Property $property): bool
    {
        return $property->user_id === $user->id
            && $property->listing_status === 'draft';
    }

    /**
     * Only admins can approve or reject listings.
     */
    public function approve(User $user, Property $property): bool
    {
        return false;
    }
}
