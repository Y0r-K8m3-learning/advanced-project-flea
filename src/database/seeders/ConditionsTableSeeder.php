<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 外部キー制約を無効化
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // テーブルのデータを削除
        DB::table('conditions')->truncate();

        // ダミーデータの挿入
        DB::table('conditions')->insert([
            ['id' => 1, 'name' => '新品'],
            ['id' => 2, 'name' => '良好'],
            ['id' => 3, 'name' => '中古'],
        ]);

        // 外部キー制約を有効化
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
