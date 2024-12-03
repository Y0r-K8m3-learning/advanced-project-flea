<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 外部キー制約を無効化
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // テーブルのデータを削除
        DB::table('categories')->truncate();

        // ダミーデータの挿入
        DB::table('categories')->insert([
            ['id' => 1, 'name' => '洋服'],
            ['id' => 2, 'name' =>
            'メンズ'],
            ['id' => 3, 'name'
            => 'スポーツ'],
            ['id' => 4, 'name' => 'レディース'],
        ]);

        // 外部キー制約を有効化
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
