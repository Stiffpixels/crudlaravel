<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->word()." ".fake()->word();
        return [
            'name'=> $name,
            'description'=>fake()->sentence(),
            'cover_img'=>"https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcT1qem6_pVSdrUYexq_OhE9D-hJT0VLK6buuRDsPCm84CIRMCd09_3mIUgDR3rOXLjwU-KAKdxtyD9cZ66TNL-5mm88dCpRy02E58XLEpszP6scn7Eb0NjSjw&usqp=CAE",
            'slug'=> str_replace(" ", "-", $name),
        ];
    }
}
