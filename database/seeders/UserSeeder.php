<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'د. أحمد محمد',
            'email' => 'doctor1@clinic.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\User::create([
            'name' => 'د. سارة علي',
            'email' => 'doctor2@clinic.com',
            'password' => bcrypt('password'),
        ]);
    }
}
