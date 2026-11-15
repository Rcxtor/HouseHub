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
        $adminEmail = env('ADMIN_EMAIL');
        $adminPassword = env('ADMIN_PASSWORD');

        $demoPassword = env('DEMO_USER_PASSWORD');

        if (!$adminEmail || !$adminPassword) {
            throw new RuntimeException(
                'Admin email and password must be configured in .env'
            );
        }

        if (!$demoPassword) {
            throw new RuntimeException(
                'DEMO_USER_PASSWORD must be configured in .env'
            );
        }

        // Retrieve required roles.
        $roles = Role::whereIn('name', [
            'admin',
            'owner',
            'renter',
        ])->get()->keyBy('name');

        foreach (['admin', 'owner', 'renter'] as $roleName) {
            if (!$roles->has($roleName)) {
                throw new RuntimeException(
                    "The {$roleName} role does not exist. Run RoleSeeder first."
                );
            }
        }

        // 1. Admin account
        $admin = User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'HouseHub Admin',
                'password' => Hash::make($adminPassword),
                'email_verified_at' => now(),
            ]
        );

        $admin->roles()->syncWithoutDetaching([
            $roles['admin']->id,
        ]);

        // 2. Demo users
        $demoUsers = [
            [
                'name' => 'Rahim Ahmed',
                'email' => 'rahim.owner@househub.test',
                'role' => 'owner',
            ],
            [
                'name' => 'Karim Hasan',
                'email' => 'karim.owner@househub.test',
                'role' => 'owner',
            ],
            [
                'name' => 'Nusrat Jahan',
                'email' => 'nusrat.owner@househub.test',
                'role' => 'owner',
            ],
            [
                'name' => 'Sadia Islam',
                'email' => 'sadia.renter@househub.test',
                'role' => 'renter',
            ],
            [
                'name' => 'Tanvir Hossain',
                'email' => 'tanvir.renter@househub.test',
                'role' => 'renter',
            ],
            [
                'name' => 'Mehedi Hasan',
                'email' => 'mehedi.renter@househub.test',
                'role' => 'renter',
            ],
        ];

        foreach ($demoUsers as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($demoPassword),
                    'email_verified_at' => now(),
                ]
            );

            $user->roles()->syncWithoutDetaching([
                $roles[$data['role']]->id,
            ]);
        }
    }
}
