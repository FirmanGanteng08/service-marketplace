<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Super Admin
        User::create([
            'name' => 'Super Admin JasaQu',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
            'status' => 'active',
            'phone' => '081234567890',
        ]);

        // 2. Buat Akun Provider (Penjual Jasa)
        User::create([
            'name' => 'Budi Studio',
            'email' => 'provider@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'provider',
            'status' => 'active',
            'phone' => '089876543210',
        ]);

        // 3. Buat Akun User (Pembeli Biasa)
        User::create([
            'name' => 'Siti Pembeli',
            'email' => 'user@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'status' => 'active',
            'phone' => '085555555555',
        ]);
    }
}