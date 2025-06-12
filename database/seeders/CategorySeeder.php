<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $categories = [
                [
                    'name' => 'Programming & Tech',
                    'slug' => 'programming-tech',
                    'image' => 'categories/programming.jpg',
                    'description' => 'Apps, websites, and IT systems'
                ],
                [
                    'name' => 'Graphics & Design',
                    'slug' => 'graphics-design',
                    'image' => 'categories/design.jpg',
                    'description' => 'Visual Design'
                ],
                [
                    'name' => 'Digital Marketing',
                    'slug' => 'digital-marketing',
                    'image' => 'categories/digital-marketing.jpg',
                    'description' => 'Boost sales and visibilitys'
                ],
                [
                    'name' => 'Writing & Translation',
                    'slug' => 'writing-translation',
                    'image' => 'categories/writing-translation.jpg',
                    'description' => 'Quality content in various languages'
                ],
                [
                    'name' => 'Photography',
                    'slug' => 'photography',
                    'image' => 'categories/photography.jpg',
                    'description' => 'Beautiful moments that last forever'
                ],
                [
                    'name' => 'Business',
                    'slug' => 'business',
                    'image' => 'categories/business.jpg',
                    'description' => 'Solutions for business development'
                ],
            ];
            
            foreach ($categories as $category) {
        try {
            Category::firstOrCreate(
                ['slug' => $category['slug']], // Cek berdasarkan slug
                $category
            );
        } catch (\Exception $e) {
            \Log::error("Failed to create category {$category['name']}: " . $e->getMessage());
        }
    }
    }
}
