<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin123',
            'email' => 'admin@easykasir.com',
            'email_verified_at' => now(),
            'password' => Hash::make('user'), // Ganti dengan password aman
            'role' => 'administrator',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            
        ]);
    }
}
