<?php

namespace Database\Seeders;

use App\Models\Products\Category;
use App\Models\Products\Product;
use App\Models\Products\Tag;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run () : void
    {
        // Спочатку створюємо кореневі категорії
        Category::factory()->count(3)->create();

// Додаємо другий рівень
        Category::factory()->count(5)->create();

// Додаємо третій рівень
        Category::factory()->count(7)->create();

// Додаємо четвертий рівень
        Category::factory()->count(10)->create();
        Tag::factory()->count(20)->create();
        Product::factory()->count(100)->create();
    }
}
