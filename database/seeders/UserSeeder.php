<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => '山田',
                'email' => 'yamada@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => '佐藤',
                'email' => 'sato@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => '田中',
                'email' => 'tanaka@example.com',
                'password' => Hash::make('password'),
            ],
        ]);
    }
}
