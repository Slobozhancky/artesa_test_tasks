<?php

namespace Database\Factories\Products;

use App\Models\Products\Category;
use App\Models\Products\Product;
use App\Models\Products\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'product_name' => fake()->word(),
            'product_price' => fake()->randomFloat(2, 1, 100), // Генеруємо ціну між 1 і 100
            'product_quantity' => fake()->numberBetween(1, 100), // Генеруємо кількість між 1 і 100
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $categories = Category::inRandomOrder()->take(random_int(1, 3))->pluck('id');
            $product->categories()->attach($categories);

            $tags = Tag::inRandomOrder()->take(random_int(1, 5))->pluck('id');
            $product->tags()->attach($tags);
        });
    }
}
