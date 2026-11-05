<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (!$email || !$password) {
            throw new RuntimeException(
                'Admin email and password must be configured in .env'
            );
        }

        // Find or create admin account.
        $admin = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'HouseHub Admin',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        // Find the admin role.
        $adminRole = Role::where('name', 'admin')->firstOrFail();

        // Assign admin role without creating duplicates.
        $admin->roles()->syncWithoutDetaching([
            $adminRole->id,
        ]);
    }
}
