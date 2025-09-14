<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProdUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'id' => 27,
                'name' => 'admin',
                'password' => '$2y$12$kaRMo0O/wuy9fNnE960.0ePKdn1.UuZ/eyqP1FYKmcc7a8/BmEKCi',
                'user_type' => 'admin',
                'created_at' => '2025-09-12 22:14:46',
                'updated_at' => '2025-09-12 22:14:46',
            ]
        );

        // User (Amelia)
        User::updateOrCreate(
            ['email' => 'melstask95@gmail.com'],
            [
                'id' => 28,
                'name' => 'Amelia',
                'avatar_path' => 'avatars/wIWpWbozLS3ciRh7tyzhbPYgqSbSHbzpP8AnO0Js.png',
                'alamat' => 'Jalan Raya Dompak',
                'password' => '$2y$12$AZaya2gZL96h4kWjkQ6IR.y5rqKvvyV1yabo3hmhYQGvNYsRrs6nG',
                'user_type' => 'user',
                'created_at' => '2025-09-12 22:45:55',
                'updated_at' => '2025-09-13 00:23:20',
            ]
        );
    }
}
