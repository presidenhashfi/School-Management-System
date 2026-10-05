<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_users')->insert([
            [
                'username' => 'admin_utama',
                'email' => 'admin@school.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'archived' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'guru_budi',
                'email' => 'teacher@school.com',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
                'archived' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'siswa_andi',
                'email' => 'student@school.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'archived' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}