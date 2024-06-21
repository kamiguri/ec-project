<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [ 'name' => 'ワイヤレスイヤホン' ],
            [ 'name' => '有線イヤホン' ],
            [ 'name' => 'ワイヤレスヘッドホン' ],
            [ 'name' => '有線ヘッドホン' ],
            [ 'name' => 'ワイヤレススピーカー' ],
            [ 'name' => '有線スピーカー' ],
        ]);
    }
}
