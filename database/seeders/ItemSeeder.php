<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            [
                'seller_id' => 1,
                'category_id' => 1,
                'name' => 'Beats Studio Buds',
                'photo_path' => 'storage/item_images/Beats Studio.png',
                'description' => 'フルワイヤレスイヤホン Beats Studio Buds + アイボリー MQLJ3PA/A [ワイヤレス(左右分離) /ノイズキャンセリング対応 /Bluetooth対応]',
                'price' => 22800,
                'stock' => 100,
                'is_show' => true,
            ]
        ]);
    }
}
