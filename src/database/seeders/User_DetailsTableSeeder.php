<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class User_DetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 外部キー制約を無効化してテーブルをクリア
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users_details')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ユーザーIDを取得
        $userIds = DB::table('users')->pluck('id')->toArray(); // users テーブルの ID

        // ダミーデータの作成
        $userDetails = [];
        foreach ($userIds as $userId) {
            $userDetails[] = [
                'user_id' => $userId,
                'image_id' => 'images/user_' . $userId . '.png', // ダミー画像パス
                'post_code' => '123-456' . $userId, // ダミー郵便番号
                'address' => '東京都渋谷区道玄坂 ' . $userId . '丁目', // ダミー住所
                'building' => 'ダミービル ' . $userId, // ダミービル名
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // データ挿入
        DB::table('users_details')->insert($userDetails);
    }
}
