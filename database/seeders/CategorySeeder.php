<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Makanan Tradisional',
            'Makanan Modern',
            'Street Food',
            'Seafood',
            'Vegetarian',
            'Fast Food',
            'Dll',
        ];


        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }

}
