<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            [
                'email' => 'admin@servicehub.test',
            ],
            [
                'name' => 'ServiceHub Admin',
                'password' => 'password',
                'role' => 'admin',
            ]
        );
    }
}

