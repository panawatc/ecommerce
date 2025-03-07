<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $electronics = Category::where('slug', 'electronics')->first();
        $clothing = Category::where('slug', 'clothing')->first();
        $books = Category::where('slug', 'books')->first();
        
        // Electronics products
        Product::create([
            'name' => 'Smartphone X',
            'description' => 'The latest smartphone with amazing features.',
            'price' => 699.99,
            'stock' => 50,
            'category_id' => $electronics->id,
        ]);
        
        Product::create([
            'name' => 'Laptop Pro',
            'description' => 'High performance laptop for professionals.',
            'price' => 1299.99,
            'stock' => 30,
            'category_id' => $electronics->id,
        ]);
        
        // Clothing products
        Product::create([
            'name' => 'Casual T-Shirt',
            'description' => 'Comfortable cotton t-shirt for everyday wear.',
            'price' => 19.99,
            'stock' => 100,
            'category_id' => $clothing->id,
        ]);
        
        Product::create([
            'name' => 'Jeans',
            'description' => 'Classic blue jeans with perfect fit.',
            'price' => 49.99,
            'stock' => 80,
            'category_id' => $clothing->id,
        ]);
        
        // Books products
        Product::create([
            'name' => 'Programming in PHP',
            'description' => 'Learn PHP programming from scratch.',
            'price' => 29.99,
            'stock' => 40,
            'category_id' => $books->id,
        ]);
        
        Product::create([
            'name' => 'Web Development Guide',
            'description' => 'Comprehensive guide to modern web development.',
            'price' => 34.99,
            'stock' => 35,
            'category_id' => $books->id,
       ]);
   }
}