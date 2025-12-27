<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a dummy admin user directly, bypassing the factory,
        // as the factory's Faker instance is not initializing correctly in the CI environment.
        User::create([
            'name' => 'Dummy User',
            'email' => 'dummy@user.com',
            'email_verified_at' => now(),
            'password' => Hash::make('dummyuser'),
        ]);
    }
}