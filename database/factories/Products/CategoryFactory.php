<?php

namespace Database\Factories\Products;

use App\Models\Products\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Category::class;

    public function definition(): array
    {

        $parentCategory = Category::inRandomOrder()->first();

        return [
            'title' => $this->faker->unique()->word(),
            'parent_id' => ($parentCategory && $parentCategory->getDepth() < 3)
                ? $parentCategory->id
                : null,
        ];
    }
}
