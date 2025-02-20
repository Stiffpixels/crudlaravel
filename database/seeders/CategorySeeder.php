<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::factory()
                            ->count(10)
                            ->create();
        
        foreach($categories as $category){
            Product::factory()
                ->count(20)
                ->create(["category_id"=>$category->id]);
        }
    }
}
