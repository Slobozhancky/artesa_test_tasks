<?php

namespace Database\Factories\Products;

use App\Models\Products\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Tag::class;

    public function definition () : array
    {
        return [
            'name' => fake()->unique()->word() ,
        ];
    }
}
