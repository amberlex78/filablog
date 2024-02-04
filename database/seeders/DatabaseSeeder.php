<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Blog\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public const IMAGE_URL = 'https://source.unsplash.com/random/200x200/?img=1';

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PageSeeder::class,
        ]);

        Category::factory(5)->create();
    }
}
