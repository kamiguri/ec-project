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

        $prices = [
            'AKG N9.jpg' => 55000,
            'akg_k701.jpg' => 18800,
            'akg_k712.jpg' => 31800,
            'BoseNoiseCancellingHeadphones700.jpg' => 34980,
            'BoseQuietComfortEarbudsII.jpg' => 27720,
            'HD660S2.jpg' => 96800,
            'HT-A9000.jpg' => 209000,
            'IE100PROClear.jpg' => 12860,
            'IER-M9.jpg' => 165000,
            'MDR-Z1R.jpg' => 253000,
            'WH-1000XM4.jpg' => 48400,
            'WH-1000XM5.jpg' => 59400,
            'momentamtruewireless4.jpg' => 49940,
            'MOMENTUM 4 Wireless.jpg' => 54890,
            'MDR-Z7M2.jpg' => 253000,
            'moondrop-cosmo.jpg' => 143573,
            'MoonDropMAY.jpg' => 12600,
            'WF-1000XM4.jpg' => 39800,
            'WF-1000XM5.jpg' => 41800,
            "MoonDropGoldenAges" => 14400,
        ];
        $i = 0;
        foreach ($images as $image) {

            // 画像ファイルのパスからファイル名を取得
            $fileName = basename($image);
            // ファイル名から拡張子を除去
            $name = pathinfo($fileName, PATHINFO_FILENAME);
            // 価格の設定
            $price = array_key_exists($fileName, $prices) ? $prices[$fileName] : 0;
            // データベースに登録するデータを作成
            $data = [
                'seller_id' => 1,
                'category_id' => fake()->numberBetween(1, 6),
                'name' => $name,
                'photo_path' => 'storage/item_images/' . $fileName,
                'description' => '画像のテストです。音楽っていいよね・・・',
                'price' => $price,
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
