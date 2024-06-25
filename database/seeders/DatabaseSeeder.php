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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory(10)->create();

        $this->call([
            CategorySeeder::class,
        ]);

        $seller = Seller::factory()
            ->create([
                'name' => 'Test Seller',
                'email' => 'seller@example.com',
            ]);

        $items = Item::factory(10)
            ->hasAttached(Order::factory(5), function($item) {
                return [
                    'amount' => fake()->numberBetween(1, 5),
                    'price' => $item->price
                ];
            })
            ->for($seller)
            ->create();
    }
}
