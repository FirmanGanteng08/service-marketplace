<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServicePackage;
use App\Models\ProviderProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat 3 Akun Utama (Super Admin, Provider, User Biasa)
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'super_admin'
        ]);

        $provider = User::create([
            'name' => 'Budi Jasa',
            'email' => 'provider@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'provider'
        ]);

        $user = User::create([
            'name' => 'Pembeli Biasa',
            'email' => 'user@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'user'
        ]);

        // 2. Buat Dompet (Wallet) dengan saldo awal
        Wallet::create(['user_id' => $provider->id, 'balance' => 0]);
        Wallet::create(['user_id' => $user->id, 'balance' => 500000]); // Pembeli dikasih modal 500rb

        // 3. Buat Profil Toko/Provider
        ProviderProfile::create([
            'user_id' => $provider->id,
            'business_name' => 'Budi Creative Studio',
            'description' => 'Melayani berbagai jasa digital profesional.',
            'is_verified' => true
        ]);

        // 4. Buat Kategori
        $kategori1 = Category::create(['name' => 'Desain Grafis', 'slug' => Str::slug('Desain Grafis')]);
        $kategori2 = Category::create(['name' => 'Pemrograman Web', 'slug' => Str::slug('Pemrograman Web')]);

        // 5. Buat 1 Contoh Jasa
        $jasa = Service::create([
            'provider_id' => $provider->id,
            'category_id' => $kategori1->id,
            'title' => 'Jasa Desain Logo Profesional',
            'description' => 'Saya akan membuatkan logo yang elegan dan modern untuk bisnis Anda.',
            'status' => 'active'
        ]);

        // 6. Buat 3 Paket (Basic, Standard, Premium) untuk jasa di atas
        ServicePackage::insert([
            [
                'service_id' => $jasa->id,
                'name' => 'Basic',
                'price' => 50000,
                'duration_days' => 2,
                'revision_limit' => 1,
                'features' => json_encode(['1 Pilihan Logo', 'File JPG/PNG']),
            ],
            [
                'service_id' => $jasa->id,
                'name' => 'Standard',
                'price' => 100000,
                'duration_days' => 3,
                'revision_limit' => 3,
                'features' => json_encode(['3 Pilihan Logo', 'File Master (AI/PSD)', 'High Resolution']),
            ],
            [
                'service_id' => $jasa->id,
                'name' => 'Premium',
                'price' => 250000,
                'duration_days' => 5,
                'revision_limit' => 99, // 99 kita anggap unlimited
                'features' => json_encode(['5 Pilihan Logo', 'Semua File Master', 'Desain Kartu Nama', 'Prioritas Pengerjaan']),
            ]
        ]);
    }
}