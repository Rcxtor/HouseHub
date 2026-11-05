<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile_photo_path' => $this->profile_photo_path,

            'email_verified_at' => $this->email_verified_at,
            'phone_verified_at' => $this->phone_verified_at,

            'roles' => $this->whenLoaded(
                'roles',
                fn() => $this->roles->pluck('name')
            ),

            'owner_profile' => $this->whenLoaded(
                'ownerProfile',
                fn() => $this->ownerProfile
            ),

            'created_at' => $this->created_at,
        ];
    }
}
