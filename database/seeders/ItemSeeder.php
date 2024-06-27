<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Seller;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // storage/item_images ディレクトリ内の画像ファイルを取得
        $images = Storage::disk('public')->files('item_images');

        foreach ($images as $image) {
            // 画像ファイルのパスからファイル名を取得
            $fileName = basename($image);
            // ファイル名から拡張子を除去
            $name = pathinfo($fileName, PATHINFO_FILENAME);

            // データベースに登録するデータを作成
            $data = [
                'seller_id' => 1,
                'category_id' => fake()->numberBetween(1, 6),
                'name' => $name,
                'photo_path' => 'storage/item_images/' . $fileName,
                'description' => '画像のテストです。音楽っていいよね・・・',
                'price' => fake()->numberBetween(100, 100000),
                'stock' => fake()->numberBetween(10, 100),
                'is_show' => true,
                'created_at' => fake()->dateTime(),
                'updated_at' => fake()->dateTime(),
            ];

            // データベースに登録
            DB::table('items')->insert($data);
        }
    }
}
