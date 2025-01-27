<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テーブルのデータを削除
        DB::table('favorites')->truncate();

        // ユーザーIDとアイテムIDを取得
        $userIds = DB::table('users')->pluck('id')->toArray(); // users テーブルの ID
        $itemIds = DB::table('items')->pluck('id')->toArray(); // items テーブルの ID

        // ダミーデータの作成
        $favorites = [];
        for ($i = 1; $i <= 3; $i++) { // 10件分のダミーデータを作成
            $favorites[] = [
                'id' => $i,
                'user_id' => $userIds[array_rand($userIds)], // ランダムなユーザーID
                'item_id' => $itemIds[array_rand($itemIds)], // ランダムなアイテムID
            ];
        }

        // ダミーデータの挿入
        DB::table('favorites')->insert($favorites);
    }
}
