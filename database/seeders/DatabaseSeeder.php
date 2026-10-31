<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
             ['name' => 'Budi Santoso',    'email' => 'budi@merchflow.test',  'role' => 'customer'],
        ];

        // Kolom role hanya diisi kalau sudah ada di tabel users
        $hasRole = Schema::hasColumn('users', 'role');

        foreach ($users as $u) {
            $data = [
                'name' => $u['name'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ];

            if ($hasRole) {
                $data['role'] = $u['role'];
            }

            // updateOrCreate: aman dijalankan berulang, email yang sama tidak dobel
            User::updateOrCreate(['email' => $u['email']], $data);
        }
    }
}
