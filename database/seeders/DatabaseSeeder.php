<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin MerchFlow',
                'email' => 'admin@merchflow.test',
                'role' => 'admin',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@merchflow.test',
                'role' => 'staff',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => 'password',
                    'role' => $user['role'],
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}

