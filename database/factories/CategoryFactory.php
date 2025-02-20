<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->word();
        return [
            'name'=> $name,
            'cover_img'=>"https://www.shutterstock.com/image-vector/grunge-green-category-word-round-260nw-1794170542.jpg",
            'slug'=> $name,
        ];
    }
}
