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

        // User::factory(10)->create();

        $this->call([
            CategorySeeder::class,
        ]);

        $items = Item::factory(10)
        ->hasAttached(
            Order::factory()->count(5),
            [
                ['price' => fake()->numberBetween(100, 100000)],
                ['amount' => fake()->numberBetween(1, 5)],
            ]
            );

        $seller = Seller::factory()
            ->has($items)
            ->create([
                'name' => 'Test Seller',
                'email' => 'seller@example.com',
            ]);

        // Order::factory(5)
        // ->hasAttached(
        //     $items->state(function (array $attributes, Item $item) {
        //             return [
        //                 ['price' => $item->price],
        //                 ['amount' => fake()->numberBetween(1, 5)],
        //             ];
        //         })
        // )
        // ->create();

    }
}
