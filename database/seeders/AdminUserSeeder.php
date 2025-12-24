<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@clinic.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Assign admin role
        $admin->assignRole('admin');

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@clinic.com');
        $this->command->info('Password: password123');
    }
}
