<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 外部キー制約を無効化してテーブルをクリア
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('orders')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ユーザーIDとアイテムIDを取得
        $userIds = DB::table('users')->pluck('id')->toArray(); // users テーブルの ID
        $itemIds = DB::table('items')->pluck('id')->toArray(); // items テーブルの ID

        // ダミーデータの作成
        $orders = [];
        for ($i = 1; $i <= 10; $i++) { // 10件分のデータを作成
            $orders[] = [
                'id' => $i,
                'user_id' => $userIds[array_rand($userIds)], // ランダムな user_id
                'item_id' => $itemIds[array_rand($itemIds)], // ランダムな item_id
            ];
        }

        // データ挿入
        DB::table('orders')->insert($orders);
    }
}
