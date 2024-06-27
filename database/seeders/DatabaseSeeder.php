<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Order;
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
        Seller::factory()->create([
            'name' => 'Test Seller',
            'email' => 'seller@example.com',
        ]);

        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
        ]);

        Item::factory(10)->create();

        Order::factory(5)
        ->hasAttached(
            Item::factory()->count(fake()->numberBetween(1, 3)),
            [
                'amount' => fake()->numberBetween(1, 5),
                'price' => fake()->numberBetween(100, 100000),
            ],
        )
        ->create();

    }
}
