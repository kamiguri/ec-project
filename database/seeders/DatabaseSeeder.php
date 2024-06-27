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
        $this->call([
            CategorySeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $users = User::factory(20)->create();

        $seller = Seller::factory()
            ->create([
                'name' => 'Test Seller',
                'email' => 'seller@example.com',
            ]);

        $items = Item::factory(30)->for($seller)->create();

        Order::factory(300)
            ->recycle($users)
            ->create()
            ->each(function ($order) use ($items) {
                $itemIdsToAttach = $items->random(rand(1, 5))->pluck('id')->toArray();
                foreach ($itemIdsToAttach as $id) {
                    $order->items()->attach($id, [
                        'amount' => fake()->numberBetween(1, 5), 'price' => $items->find($id)->price
                    ]);
                }
            });

        $seller2 = Seller::factory()
            ->create([
                'name' => 'Test Seller2',
                'email' => 'seller2@example.com',
            ]);
        $seller2items = Item::factory(30)->for($seller2)->create();
        Order::factory(100)
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
