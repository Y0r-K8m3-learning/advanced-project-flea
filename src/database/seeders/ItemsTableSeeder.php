<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テーブルのデータを削除
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('items')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ダミーデータの挿入
        DB::table('items')->insert([
            [
                'seller_id' => 1, // users テーブルに存在する ID
                'name' => '商品A',
                'price' => 1200,
                'description' => '高品質な商品Aです。',
                'item_category_id' => 1, // item_category テーブルに存在する ID
                'image_url' => 'images/item_a.png',
                'sales_flg' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 2,
                'name' => '商品B',
                'price' => 2500,
                'description' => '素晴らしい商品Bをご覧ください。',
                'item_category_id' => 2,
                'image_url' => 'images/item_b.png',
                'sales_flg' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 1,
                'name' => '商品C',
                'price' => 3000,
                'description' => '最新モデルの商品Cです。',
                'item_category_id' => 3,
                'image_url' => 'images/item_c.png',
                'sales_flg' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
