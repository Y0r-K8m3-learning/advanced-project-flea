<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Item_CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テーブルのデータを削除
        DB::table('item_category')->truncate();

        // items テーブルと categories テーブルの ID を取得
        $itemIds = DB::table('items')->pluck('id')->toArray();       // items テーブルの ID
        $categoryIds = DB::table('categories')->pluck('id')->toArray(); // categories テーブルの ID

        // ダミーデータの作成
        $itemCategories = [];
        for ($i = 1; $i <= 10; $i++) { // 10件分のデータを作成
            $itemCategories[] = [
                'id' => $i,
                'item_id' => $itemIds[array_rand($itemIds)],       // ランダムな item_id
                'category_id' => $categoryIds[array_rand($categoryIds)], // ランダムな category_id
            ];
        }

        // データ挿入
        DB::table('item_category')->insert($itemCategories);
    }
}
