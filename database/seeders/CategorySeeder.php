<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Clothing' => ['Traditional', 'Modern', 'Sportswear'],
            'Beauty' => ['Perfume', 'Makeup', 'Skincare'],
            'Computer Accessories' => ['Cables', 'Keyboards', 'Mice'],
            'Home & Kitchen' => ['Cookware', 'Decoration', 'Furniture'],
            'Electronics' => ['Phones', 'Tablets', 'Audio'],
        ];

        foreach ($categories as $main => $subs) {
            $mainCat = Category::create(['name' => $main]);
            foreach ($subs as $sub) {
                Category::create(['name' => $sub, 'parent_id' => $mainCat->id]);
            }
        }
    }
}