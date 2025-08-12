<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super admin
        Admin::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'super_admin'
        ]);
        // Admin Biasa
        Admin::create([
            'name' => 'Admin Biasa',
            'email' => 'admin_biasa@example.com',
            'password' => Hash::make('password456'),
            'role' => 'admin_biasa'
        ]);
    }
}
