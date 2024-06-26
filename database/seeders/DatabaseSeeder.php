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
        Seller::factory()
            ->create([
                'name' => 'Test Seller',
                'email' => 'seller@example.com',
            ]);

        $this->call([
            CategorySeeder::class,
            ItemSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $users = User::factory(20)->create();

        $seller2 = Seller::factory()
            ->create([
                'name' => 'Test Seller2',
                'email' => 'seller2@example.com',
            ]);
        $seller2items = Item::factory(30)->for($seller2)->create();
        Order::factory(300)
            ->recycle($users)
            ->create()
            ->each(function ($order) use ($seller2items) {
                $itemIdsToAttach = $seller2items->random(rand(1, 5))->pluck('id')->toArray();
                foreach ($itemIdsToAttach as $id) {
                    $order->items()->attach($id, [
                        'amount' => fake()->numberBetween(1, 5), 'price' => $seller2items->find($id)->price
                    ]);
                }
            });
    }
}
