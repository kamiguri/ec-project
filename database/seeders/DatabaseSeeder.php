<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use App\Models\Seller;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Seller::factory()->create([
            'name' => 'Test Seller',
            'email' => 'seller@example.com',
        ]);

        $this->call([
            CategorySeeder::class,
        ]);

        Item::factory()->create();
    }
}
