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
                'image_url' => 'images/item_a.png',
                'sales_flg' => true,
                'brand' => 'ブランドA',
                'condition_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 2,
                'name' => '商品B',
                'price' => 2500,
                'description' => '素晴らしい商品Bをご覧ください。',
                'image_url' => 'images/item_b.png',
                'brand' => 'ブランドA',
                'sales_flg' => false,
                'condition_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 1,
                'name' => '商品C',
                'price' => 3000,
                'description' => '最新モデルの商品Cです。',
                'image_url' => 'images/item_c.png',
                'brand' => 'ブランドA',
                'sales_flg' => true,
                'condition_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 3, // users テーブルに存在する ID
                'name' => '商品D',
                'price' => 1800,
                'description' => 'お手頃価格の商品Dです。',
                'image_url' => 'images/item_d.png',
                'brand' => 'ブランドA',
                'sales_flg' => true,
                'condition_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 2,
                'name' => '商品E',
                'price' => 4000,
                'description' => '高級感のある商品Eです。',
                'image_url' => 'images/item_a.png',
                'brand' => 'ブランドA',
                'sales_flg' => true,
                'condition_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 4,
                'name' => '商品F',
                'price' => 1500,
                'description' => 'コスパ最高の商品Fです。',
                'image_url' => 'images/item_b.png',
                'brand' => 'ブランドB',
                'sales_flg' => false,
                'condition_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 3,
                'name' => '商品G',
                'price' => 2200,
                'description' => '人気の高い商品Gです。',
                'image_url' => 'images/item_c.png',
                'brand' => 'ブランドC',
                'condition_id' => 1,
                'sales_flg' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 5,
                'name' => '商品H',
                'price' => 3500,
                'description' => '高品質でデザイン性のある商品Hです。',
                'image_url' => 'images/item_d.png',
                'condition_id' => 3,
                'brand' => 'ブランドC',
                'sales_flg' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
