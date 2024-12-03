<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Monolog\Handler\RollbarHandler;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 作成した Seeder を呼び出す
        $this->call([
            CategoriesTableSeeder::class,        // Users Seeder
            ConditionsTableSeeder::class,        // Users Seeder
            RolesTableSeeder::class, // ItemCategory Seeder
            UserSeeder::class,        // Users Seeder
            User_DetailsTableSeeder::class, // UsersDetails Seeder
            ItemsTableSeeder::class,        // Items Seeder
            FavoritesTableSeeder::class,    // Favorites Seeder
            ReviewsTableSeeder::class,      // Reviews Seeder
            Item_CategoryTableSeeder::class, // ItemCategory Seeder
            OrdersTableSeeder::class, // ItemCategory Seeder
        ]);
    }
}
